<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ManageUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:manage
                            {email? : E-Mail-Adresse des Benutzers (zum Suchen oder Neu-Anlegen)}
                            {--id= : Benutzer-ID (falls über ID aktualisiert werden soll)}
                            {--name= : Name des Benutzers}
                            {--email= : Neue oder zu suchende E-Mail-Adresse}
                            {--phone= : Telefonnummer (z. B. +41791234567)}
                            {--password= : Neues Passwort}
                            {--about= : Status-/Info-Text ("Über mich")}
                            {--list : Zeigt eine Tabelle aller vorhandenen Benutzer an}';

    /**
     * Command aliases so user:create and user:update also work directly.
     *
     * @var array<int, string>
     */
    protected $aliases = [
        'user:create',
        'user:update',
        'user:upsert',
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erstellt einen neuen ChatConnect-Benutzer oder aktualisiert einen bestehenden Benutzer (interaktiv oder per Optionen).';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('list')) {
            $this->renderUserTable();
            return self::SUCCESS;
        }

        $id = $this->option('id');
        $emailArg = $this->argument('email') ?: $this->option('email');
        $nameOpt = $this->option('name');
        $phoneOpt = $this->option('phone');
        $passwordOpt = $this->option('password');
        $aboutOpt = $this->option('about');

        $hasNonInteractiveOptions = $nameOpt !== null || $phoneOpt !== null || $passwordOpt !== null || $aboutOpt !== null;

        // Suche bestehenden User über --id oder email
        $user = null;
        if ($id) {
            $user = User::find($id);
            if (!$user) {
                $this->error("Kein Benutzer mit ID {$id} gefunden.");
                return self::FAILURE;
            }
        } elseif ($emailArg) {
            $user = User::where('email', $emailArg)->first();
        }

        // Interaktiver Modus, falls keine direkten Optionen übergeben wurden
        if (!$id && !$emailArg && !$hasNonInteractiveOptions) {
            $this->info('=== ChatConnect Benutzerverwaltung (Create / Update) ===');
            $this->renderUserTable();

            $mode = $this->choice(
                'Was möchtest du tun?',
                [
                    'create' => 'Neuen Benutzer erstellen (Create)',
                    'update' => 'Bestehenden Benutzer bearbeiten (Update)',
                ],
                'create'
            );

            if ($mode === 'update' || $mode === 'Bestehenden Benutzer bearbeiten (Update)') {
                $identifier = $this->ask('Bitte Benutzer-ID oder E-Mail-Adresse eingeben');
                if (is_numeric($identifier)) {
                    $user = User::find((int) $identifier);
                } else {
                    $user = User::where('email', $identifier)->orWhere('phone', $identifier)->first();
                }

                if (!$user) {
                    $this->error("Benutzer '{$identifier}' wurde nicht gefunden.");
                    return self::FAILURE;
                }
            } else {
                $emailArg = $this->ask('E-Mail-Adresse des neuen Benutzers');
                if (!$emailArg) {
                    $this->error('E-Mail-Adresse ist erforderlich.');
                    return self::FAILURE;
                }
                $existing = User::where('email', $emailArg)->first();
                if ($existing) {
                    $this->warn("Benutzer mit E-Mail '{$emailArg}' existiert bereits (ID: {$existing->id}). Wechsle in den Update-Modus.");
                    $user = $existing;
                }
            }
        }

        if ($user) {
            // UPDATE BESTEHENDER BENUTZER
            $this->info("Aktualisiere Benutzer #{$user->id} ({$user->name} <{$user->email}>)");

            $newName = $nameOpt ?? (!$hasNonInteractiveOptions ? $this->ask('Name', $user->name) : $user->name);
            $newEmail = ($this->option('email') ?: $emailArg) ?? $user->email;
            if (!$hasNonInteractiveOptions) {
                $newEmail = $this->ask('E-Mail-Adresse', $user->email);
            }

            $newPhone = $phoneOpt;
            if ($newPhone === null && !$hasNonInteractiveOptions) {
                $newPhone = $this->ask('Telefonnummer (optional, leer lassen zum Behalten)', $user->phone ?: '');
            }

            $newAbout = $aboutOpt;
            if ($newAbout === null && !$hasNonInteractiveOptions) {
                $newAbout = $this->ask('Über mich / Status', $user->about ?: 'Hallo, ich nutze ChatConnect.');
            }

            $newPassword = $passwordOpt;
            if ($newPassword === null && !$hasNonInteractiveOptions) {
                $newPassword = $this->secret('Neues Passwort (leer lassen, um Passwort nicht zu ändern)');
            }

            $user->name = $newName;
            $user->email = $newEmail;
            if ($newPhone !== null && $newPhone !== '') {
                $user->phone = $newPhone;
            }
            if ($newAbout !== null && $newAbout !== '') {
                $user->about = $newAbout;
            }
            if (!empty($newPassword)) {
                $user->password = Hash::make($newPassword);
            }
            $user->save();

            try {
                \App\Services\CopilotService::ensureBotConversationForUser($user);
            } catch (\Throwable $e) {
                // ignore optional copilot setup error
            }

            $this->info("✅ Benutzer #{$user->id} erfolgreich aktualisiert!");
        } else {
            // CREATE NEUER BENUTZER
            $newEmail = $emailArg ?: $this->ask('E-Mail-Adresse');
            if (!$newEmail) {
                $this->error('Eine E-Mail-Adresse wird benötigt.');
                return self::FAILURE;
            }

            $newName = $nameOpt ?: $this->ask('Name des Benutzers', explode('@', $newEmail)[0]);
            $newPhone = $phoneOpt !== null ? $phoneOpt : ($hasNonInteractiveOptions ? null : $this->ask('Telefonnummer (optional, z. B. +41791234567)', ''));
            $newPassword = $passwordOpt ?: ($hasNonInteractiveOptions ? 'password123' : $this->secret('Passwort (Standard: password123)'));
            if (empty($newPassword)) {
                $newPassword = 'password123';
            }
            $newAbout = $aboutOpt ?: 'Hallo, ich nutze ChatConnect.';

            if (!empty($newPhone) && User::where('phone', $newPhone)->exists()) {
                $this->error("Die Telefonnummer '{$newPhone}' ist bereits bei einem anderen Benutzer hinterlegt.");
                return self::FAILURE;
            }

            $user = User::create([
                'name' => $newName,
                'email' => $newEmail,
                'phone' => !empty($newPhone) ? $newPhone : null,
                'password' => Hash::make($newPassword),
                'about' => $newAbout,
                'email_verified_at' => now(),
            ]);

            try {
                \App\Services\CopilotService::ensureBotConversationForUser($user);
            } catch (\Throwable $e) {
                // ignore optional copilot setup error
            }

            $this->info("✅ Neuer Benutzer #{$user->id} erfolgreich erstellt!");
        }

        $this->table(
            ['ID', 'Name', 'E-Mail', 'Telefon', 'Über mich', 'Erstellt am'],
            [[
                $user->id,
                $user->name,
                $user->email,
                $user->phone ?: '-',
                $user->about ?: '-',
                $user->created_at?->format('d.m.Y H:i'),
            ]]
        );

        return self::SUCCESS;
    }

    private function renderUserTable(): void
    {
        $users = User::orderBy('id')->get(['id', 'name', 'email', 'phone', 'is_online', 'created_at']);
        if ($users->isEmpty()) {
            $this->warn('Noch keine Benutzer in der Datenbank vorhanden.');
            return;
        }

        $this->table(
            ['ID', 'Name', 'E-Mail', 'Telefon', 'Online', 'Erstellt'],
            $users->map(fn (User $u) => [
                $u->id,
                $u->name,
                $u->email,
                $u->phone ?: '-',
                $u->is_online ? 'Ja' : 'Nein',
                $u->created_at?->format('d.m.Y H:i'),
            ])->toArray()
        );
    }
}

