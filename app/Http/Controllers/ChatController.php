<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $conversations = $user->conversations()
            ->with(['users', 'lastMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->get();
        $contacts = User::orderByRaw('id = ? DESC, name ASC', [$user->id])->get();

        return view('chats.index', [
            'user' => $user,
            'conversations' => $conversations,
            'activeConversation' => null,
            'messages' => [],
            'contacts' => $contacts
        ]);
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is part of the conversation
        if (!$conversation->users->contains($user->id)) {
            abort(403);
        }

        // Mark as read first so sidebar unread_count reflects current state
        $conversation->messages()->where('sender_id', '!=', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        $conversations = $user->conversations()
            ->with(['users', 'lastMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->get();
        $contacts = User::orderByRaw('id = ? DESC, name ASC', [$user->id])->get();
        $messages = $conversation->messages()->with(['sender', 'reactions.user'])->orderBy('created_at', 'asc')->get();

        return view('chats.index', [
            'user' => $user,
            'conversations' => $conversations,
            'activeConversation' => $conversation,
            'messages' => $messages,
            'contacts' => $contacts
        ]);
    }

    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required_without_all:image,audio,document|nullable|string|max:2000',
            'image' => 'nullable|image|max:25600',
            'audio' => 'nullable|file|max:25600',
            'document' => [
                'nullable',
                'file',
                'max:512000',
                function ($attribute, $value, $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv', 'zip', '7z', 'z', 'rar', 'tar', 'gz', 'tgz', 'bz2', 'xz', 'jar', 'mcpack', 'mcworld', 'mcaddon', 'json', '3mf', 'obj', 'gcode', 'scad', 'ppt', 'pptx', 'md', 'markdown', 'stl', 'ctl'];
                    if (!in_array($ext, $allowed)) {
                        $fail('Dateityp .' . $ext . ' wird nicht unterstützt.');
                    }
                },
            ],
        ]);

        $user = Auth::user();

        if (!$conversation->users->contains($user->id)) {
            abort(403);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('audio_messages', 'public');
        }

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('document')) {
            $docFile = $request->file('document');
            $fileName = $docFile->getClientOriginalName();
            $origExt = strtolower($docFile->getClientOriginalExtension());
            $storedName = \Illuminate\Support\Str::random(40) . ($origExt ? '.' . $origExt : '');
            $filePath = $docFile->storeAs('chat_documents', $storedName, 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'content' => $request->input('content', '') ?? '',
            'image_path' => $imagePath,
            'audio_path' => $audioPath,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        $conversation->update([
            'last_message_id' => $message->id,
        ]);

        try {
            broadcast(new \App\Events\MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            \Log::warning('Broadcast failed: ' . $e->getMessage());
        }

        // Sende Push-Benachrichtigungen an App-Benutzer
        try {
            $recipients = $conversation->users()
                ->where('users.id', '!=', $user->id)
                ->whereNotNull('fcm_token')
                ->get();

            if ($recipients->count() > 0) {
                $messaging = app('firebase.messaging');
                $notificationTitle = $user->name;
                
                $notificationBody = 'Neue Nachricht';
                if ($message->content) {
                    $notificationBody = $message->content;
                } elseif ($message->file_path) {
                    $notificationBody = '📄 ' . ($message->file_name ?: 'Dokument');
                } elseif ($message->audio_path) {
                    $notificationBody = '🎤 Sprachnachricht';
                } elseif ($message->image_path) {
                    $notificationBody = '📷 Bildnachricht';
                }

                foreach ($recipients as $recipient) {
                    $fcmMessage = \Kreait\Firebase\Messaging\CloudMessage::new()->withToken($recipient->fcm_token)
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create($notificationTitle, $notificationBody))
                        ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                            'notification' => [
                                'channel_id' => 'chat_messages_channel',
                                'sound' => 'default'
                            ]
                        ]))
                        ->withData([
                            'conversation_id' => (string) $conversation->id,
                            'type' => 'chat_message'
                        ]);
                    try {
                        $messaging->send($fcmMessage);
                    } catch (\Exception $e) {
                        \Log::warning('FCM error: ' . $e->getMessage());
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Push notification failed: ' . $e->getMessage());
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => [
                    'id' => $message->id,
                    'is_me' => true,
                    'sender_name' => $user->name,
                    'content' => $message->content,
                    'image_url' => $message->image_url ?: ($message->image_path ? '/storage/' . ltrim($message->image_path, '/') : null),
                    'audio_url' => $message->audio_url ?: ($message->audio_path ? '/storage/' . ltrim($message->audio_path, '/') : null),
                    'file_url' => $message->file_url ?: ($message->file_path ? '/storage/' . ltrim($message->file_path, '/') : null),
                    'file_name' => $message->file_name,
                    'time' => $message->created_at->format('H:i'),
                    'read' => false,
                ]
            ]);
        }

        return redirect()->route('chats.show', $conversation->id);
    }

    public function newMessages(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            return response()->json([], 403);
        }

        // Mark incoming unread messages as read while chat is actively open
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $afterId = (int)$request->query('after_id', 0);
        $newMessages = $conversation->messages()
            ->with(['sender', 'reactions.user'])
            ->where('id', '>', $afterId)
            ->orderBy('id', 'asc')
            ->get();

        // Sync read status & emoji reactions for recent messages
        $recentMessages = $conversation->messages()
            ->with('reactions.user')
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        $states = [];
        foreach ($recentMessages as $m) {
            $groupedReactions = $m->reactions
                ->groupBy('reaction')
                ->map(function ($items, $emoji) use ($user) {
                    return [
                        'emoji' => $emoji,
                        'count' => $items->count(),
                        'mine' => $items->contains('user_id', $user->id),
                        'users' => $items->map(fn($r) => $r->user ? $r->user->name : 'Kontakt')->values()->all(),
                    ];
                })
                ->values()
                ->all();

            $states[$m->id] = [
                'read' => (bool)$m->read_at,
                'content' => $m->content,
                'reactions' => $groupedReactions,
            ];
        }

        $activeIds = $conversation->messages()->pluck('id')->all();

        return response()->json([
            'messages' => $newMessages->map(function ($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'is_me' => $msg->sender_id === $user->id,
                    'sender_name' => $msg->sender ? $msg->sender->name : '',
                    'content' => $msg->content,
                    'image_url' => $msg->image_url ?: ($msg->image_path ? '/storage/' . ltrim($msg->image_path, '/') : null),
                    'audio_url' => $msg->audio_url ?: ($msg->audio_path ? '/storage/' . ltrim($msg->audio_path, '/') : null),
                    'file_url' => $msg->file_url ?: ($msg->file_path ? '/storage/' . ltrim($msg->file_path, '/') : null),
                    'file_name' => $msg->file_name,
                    'time' => $msg->created_at->format('H:i'),
                    'read' => (bool)$msg->read_at,
                ];
            }),
            'states' => $states,
            'active_ids' => $activeIds,
        ]);
    }

    public function start(Request $request, ?User $user = null)
    {
        $targetUserId = $user ? $user->id : ($request->input('user_id') ?? $request->route('user'));
        if (!$targetUserId) {
            return redirect()->route('chats.index');
        }

        $currentUser = Auth::user();

        if ((int) $targetUserId === (int) $currentUser->id) {
            // Eigener Chat ("An mich selbst")
            $conversation = $currentUser->conversations()
                ->where('is_group', false)
                ->whereDoesntHave('users', function($q) use ($currentUser) {
                    $q->where('users.id', '!=', $currentUser->id);
                })->first();

            if (!$conversation) {
                $conversation = Conversation::create(['is_group' => false]);
                $conversation->users()->attach([$currentUser->id]);
            }
        } else {
            // Finde existierenden 1-zu-1 Chat zwischen den beiden
            $conversation = $currentUser->conversations()
                ->where('is_group', false)
                ->whereHas('users', function($q) use ($targetUserId) {
                    $q->where('users.id', $targetUserId);
                })->first();

            // Falls nicht vorhanden, neu erstellen
            if (!$conversation) {
                $conversation = Conversation::create(['is_group' => false]);
                $conversation->users()->attach([$currentUser->id, $targetUserId]);
            }
        }

        return redirect()->route('chats.show', $conversation->id);
    }

    public function destroy(Request $request, Message $message)
    {
        try {
            $conversationId = $message->conversation_id;
            $conversation = \App\Models\Conversation::find($conversationId);

            if (!$conversation || !$conversation->users()->where('users.id', Auth::id())->exists()) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['message' => 'Unauthorized'], 403);
                }
                abort(403);
            }

            $messageId = $message->id;

            if ($message->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($message->image_path);
            }

            if ($message->audio_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->audio_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($message->audio_path);
            }

            if ($message->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($message->file_path);
            }

            if ($conversation->last_message_id === $messageId) {
                $prevMessage = $conversation->messages()->where('id', '!=', $messageId)->orderBy('created_at', 'desc')->first();
                $conversation->update(['last_message_id' => $prevMessage ? $prevMessage->id : null]);
            }

            $message->delete();

            try {
                broadcast(new \App\Events\MessageDeleted($messageId, $conversationId))->toOthers();
            } catch (\Throwable $e) {
                \Log::warning('Broadcast MessageDeleted failed: ' . $e->getMessage());
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['status' => 'success', 'deleted_id' => $messageId]);
            }

            return redirect()->route('chats.show', $conversationId);
        } catch (\Throwable $e) {
            \Log::error('Error deleting message: ' . $e->getMessage());
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Fehler beim Löschen');
        }
    }

    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $conversationIds = $user->conversations()->pluck('conversations.id');

        $updatedCount = Message::whereIn('conversation_id', $conversationIds)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'updated_count' => $updatedCount,
            ]);
        }

        return back();
    }

    public function react(Request $request, Message $message)
    {
        $request->validate(['reaction' => 'required|string|max:16']);
        $user = Auth::user();

        $conversation = $message->conversation;
        if (!$conversation || !$conversation->users()->where('users.id', $user->id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $existingReaction = $message->reactions()->where('user_id', $user->id)->first();
        if ($existingReaction) {
            if ($existingReaction->reaction === $request->reaction) {
                $existingReaction->delete();
            } else {
                $existingReaction->update(['reaction' => $request->reaction]);
            }
        } else {
            $message->reactions()->create([
                'user_id' => $user->id,
                'reaction' => $request->reaction,
            ]);
        }

        $reactions = $message->reactions()->with('user')->get()->groupBy('reaction')->map(function ($group, $emoji) use ($user) {
            return [
                'emoji' => $emoji,
                'count' => $group->count(),
                'mine' => $group->contains('user_id', $user->id),
                'users' => $group->map(fn($r) => $r->user ? $r->user->name : 'Benutzer')->values()->all(),
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'message_id' => $message->id,
            'reactions' => $reactions,
        ]);
    }

    public function update(Request $request, Message $message)
    {
        $request->validate(['content' => 'required|string|max:2000']);
        $user = Auth::user();

        if ((int) $message->sender_id !== (int) $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Nur eigene Nachrichten können bearbeitet werden.'], 403);
        }

        $newText = trim($request->input('content'));
        if (!str_ends_with($newText, '(bearbeitet)')) {
            $newText .= ' (bearbeitet)';
        }

        $message->update(['content' => $newText]);

        return response()->json([
            'status' => 'success',
            'message_id' => $message->id,
            'content' => $message->content,
        ]);
    }

    public function generateAiImage(Request $request)
    {
        $prompt = trim((string) $request->input('prompt', ''));
        $style = (string) $request->input('style', 'auto');
        $model = (string) $request->input('model', 'flux');
        $width = max(256, min(2048, (int) $request->input('width', 1024)));
        $height = max(256, min(2048, (int) $request->input('height', 1024)));
        $seed = (int) ($request->input('seed') ?: random_int(1000, 999999));

        if ($prompt === '') {
            return response()->json(['status' => 'error', 'message' => 'Bitte eine Beschreibung eingeben.'], 422);
        }

        $stylePrompts = [
            'auto'           => 'high quality masterpiece, vivid colors, crisp details',
            'photorealistic' => 'photorealistic, ultra detailed 8k HDR photography, natural cinematic lighting, sharp focus',
            '3d-render'      => '3D digital art render, Pixar Disney style, Octane render, soft studio lighting, smooth 3D',
            'minecraft'      => 'Minecraft voxel block style, 3D cubic game world, official Minecraft art style, vibrant blocks',
            'cyberpunk'      => 'cyberpunk sci-fi aesthetic, glowing neon cyan and emerald lights, futuristic atmosphere, high contrast',
            'anime'          => 'Studio Ghibli anime illustration, vibrant cel-shaded colors, detailed anime scenery',
            'watercolor'     => 'artistic watercolor and oil painting, expressive brush strokes, fine art gallery quality',
            'comic'          => 'vibrant comic book illustration, bold ink outlines, dynamic pop-art colors',
            'logo'           => 'clean modern vector emblem logo design, symmetrical, minimalist professional graphic',
        ];

        // Häufige deutsche Begriffe für internationale KI-Modelle ergänzen
        $deToEn = [
            'mittelschnauzer' => 'Standard Schnauzer dog (pepper and salt coat, beard and bushy eyebrows)',
            'schnauzer'       => 'Schnauzer dog with beard',
            'liegend'         => 'lying down relaxed',
            'sitzend'         => 'sitting proudly',
            'lichtschwert'    => 'glowing lightsaber sword',
            'ritterburg'      => 'medieval knight castle with towers',
            'rakete'          => 'space rocket launching',
            'raumschiff'      => 'futuristic spaceship',
            'bergsee'         => 'crystal clear Swiss alpine mountain lake',
            'alpensee'        => 'Swiss alpine lake at sunset',
            'schweiz'         => 'Switzerland Alps scenery',
            'hund'            => 'dog',
            'katze'           => 'cat',
        ];

        $enhancedPrompt = $prompt;
        $lowerPrompt = mb_strtolower($prompt, 'UTF-8');
        foreach ($deToEn as $de => $en) {
            if (mb_strpos($lowerPrompt, $de) !== false) {
                $enhancedPrompt .= ', ' . $en;
            }
        }

        $styleSuffix = $stylePrompts[$style] ?? $stylePrompts['auto'];
        $finalPrompt = $enhancedPrompt . ', ' . $styleSuffix;

        $encodedPrompt = rawurlencode($finalPrompt);
        $allowedModels = ['flux', 'turbo', 'flux-realism', 'flux-anime', 'flux-3d'];
        $safeModel = in_array($model, $allowedModels, true) ? $model : 'flux';

        $urls = [
            "https://image.pollinations.ai/prompt/{$encodedPrompt}?width={$width}&height={$height}&seed={$seed}&nologo=true&model={$safeModel}",
            "https://image.pollinations.ai/prompt/{$encodedPrompt}?width={$width}&height={$height}&seed={$seed}&nologo=true",
        ];

        foreach ($urls as $url) {
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(18)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ChatConnectAI/2.0',
                        'Accept'     => 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
                    ])
                    ->get($url);

                if ($response->successful() && strlen($response->body()) > 2048) {
                    $mime = $response->header('Content-Type') ?: 'image/jpeg';
                    if (strpos($mime, 'image/') === false) {
                        $mime = 'image/jpeg';
                    }
                    return response()->json([
                        'status'       => 'success',
                        'source'       => 'ai',
                        'image_base64' => 'data:' . $mime . ';base64,' . base64_encode($response->body()),
                    ]);
                }
            } catch (\Throwable $e) {
                \Log::info('AI Image provider attempt failed: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status'  => 'fallback',
            'message' => 'Nutze integrierte lokale HD-Synthese',
        ]);
    }
}
