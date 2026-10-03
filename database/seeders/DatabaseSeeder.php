<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password'); // Use 'password' for all test accounts

        // Vorhandene Profilbilder im Storage finden (damit sie nach migrate:fresh nicht verloren gehen)
        $existingAvatars = \Illuminate\Support\Facades\Storage::disk('public')->files('avatars');
        $existingAvatars = array_values(array_filter($existingAvatars, fn($f) => !str_ends_with($f, '.gitignore')));
        $robertAvatar = $existingAvatars[0] ?? null;
        $lucienneAvatar = $existingAvatars[1] ?? ($existingAvatars[0] ?? null);

        // Create Main Users
        $robert = User::firstOrCreate(
            ['email' => 'robert.hofer.zuerich@bluewin.ch'],
            [
                'name' => 'Robert Hofer',
                'password' => $password,
                'phone' => '+41794865700',
                'about' => 'Gründer & App-Inhaber',
                'avatar' => $robertAvatar,
                'avatar_path' => $robertAvatar,
                'is_online' => false,
            ]
        );

        $lucienne = User::firstOrCreate(
            ['email' => 'lucienne.hofer@hispeed.ch'],
            [
                'name' => 'Lucienne Hofer',
                'password' => $password,
                'phone' => '+41791112233',
                'about' => 'ChatConnect Testerin',
                'avatar' => $lucienneAvatar,
                'avatar_path' => $lucienneAvatar,
                'is_online' => false,
            ]
        );

        $florian = User::firstOrCreate(
            ['email' => 'florian.thaler@test.com'],
            [
                'name' => 'Florian Thaler',
                'password' => $password,
                'phone' => '+41791234567',
                'about' => 'Test-Account Florian',
                'is_online' => false,
            ]
        );

        $tester = User::firstOrCreate(
            ['email' => 'tester.user@gamal.com'],
            [
                'name' => 'Tester Gamal',
                'password' => $password,
                'phone' => '+41781234567',
                'about' => 'Tablet Tester',
                'is_online' => false,
            ]
        );

        // Generate 5 random users using factory
        $randomUsers = clone User::factory(5)->create(['password' => $password]);

        // --- CONVERSATIONS ---
        
        // Chat: Robert & Florian
        $convo1 = Conversation::create(['is_group' => false]);
        $convo1->users()->attach([$robert->id, $florian->id]);
        
        $msg1 = Message::create([
            'conversation_id' => $convo1->id,
            'sender_id' => $florian->id,
            'content' => 'Hallo Robert, der ChatConnect Test läuft gut!',
        ]);
        
        $msg2 = Message::create([
            'conversation_id' => $convo1->id,
            'sender_id' => $robert->id,
            'content' => 'Super, das freut mich zu hören!',
        ]);

        $convo1->update(['last_message_id' => $msg2->id]);

        // Chat: Robert & Tester
        $convo2 = Conversation::create(['is_group' => false]);
        $convo2->users()->attach([$robert->id, $tester->id]);
        
        $msg3 = Message::create([
            'conversation_id' => $convo2->id,
            'sender_id' => $tester->id,
            'content' => 'Test vom Tablet.',
        ]);

        $convo2->update(['last_message_id' => $msg3->id]);

        // Chat: Robert & Lucienne
        $convoLucienne = Conversation::create(['is_group' => false]);
        $convoLucienne->users()->attach([$robert->id, $lucienne->id]);
        
        $msgL1 = Message::create([
            'conversation_id' => $convoLucienne->id,
            'sender_id' => $robert->id,
            'content' => 'Hallo Lucienne, wie geht es Dir?',
        ]);

        $convoLucienne->update(['last_message_id' => $msgL1->id]);

        // Group Chat
        $groupConvo = Conversation::create([
            'is_group' => true,
            'name' => 'ChatConnect Alpha Team'
        ]);
        $groupConvo->users()->attach([$robert->id, $florian->id, $tester->id, $lucienne->id]);

        $msg4 = Message::create([
            'conversation_id' => $groupConvo->id,
            'sender_id' => $robert->id,
            'content' => 'Willkommen im Gruppen-Chat!',
        ]);

        $groupConvo->update(['last_message_id' => $msg4->id]);
        
        $this->command->info('Database seeded successfully with test accounts (Password: password).');
    }
}
