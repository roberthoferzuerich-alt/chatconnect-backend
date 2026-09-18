<?php

$file = 'app/Http/Controllers/Api/MessageController.php';
$content = file_get_contents($file);

// Replace with('sender') with with(['sender', 'reactions'])
$content = str_replace(
    "->with('sender')",
    "->with(['sender', 'reactions'])",
    $content
);
$content = str_replace(
    "\$message->load('sender');",
    "\$message->load(['sender', 'reactions']);",
    $content
);

// Add react method
$reactMethod = <<<EOT
    public function react(Request \$request, Message \$message)
    {
        \$request->validate(['reaction' => 'required|string']);
        \$user = \$request->user();

        // Ensure user is part of the conversation
        \$conversation = \$message->conversation;
        if (!\$conversation->users()->where('users.id', \$user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        \$existingReaction = \$message->reactions()->where('user_id', \$user->id)->first();
        if (\$existingReaction) {
            if (\$existingReaction->reaction === \$request->reaction) {
                \$existingReaction->delete();
            } else {
                \$existingReaction->update(['reaction' => \$request->reaction]);
            }
        } else {
            \$message->reactions()->create([
                'user_id' => \$user->id,
                'reaction' => \$request->reaction,
            ]);
        }

        \$message->load(['sender', 'reactions']);
        // broadcast(new \App\Events\MessageReacted(\$message))->toOthers();

        return response()->json(\$message);
    }
}
EOT;

$content = preg_replace('/\}\s*$/', "\n" . $reactMethod, $content);
file_put_contents($file, $content);
echo "MessageController patched.\n";

$routesFile = 'routes/api.php';
$routesContent = file_get_contents($routesFile);
$routesContent = str_replace(
    "Route::post('/messages/{message}/delete', [MessageController::class, 'destroy']);",
    "Route::post('/messages/{message}/delete', [MessageController::class, 'destroy']);\n        Route::post('/messages/{message}/react', [MessageController::class, 'react']);",
    $routesContent
);
file_put_contents($routesFile, $routesContent);
echo "Routes patched.\n";

