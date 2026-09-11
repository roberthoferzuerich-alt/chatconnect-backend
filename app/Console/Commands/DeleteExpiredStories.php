<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stories:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LÃ¶scht alle abgelaufenen Storys (Ã¤lter als 24h) mitsamt ihren physischen Bildern vom Server.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Hole alle Storys, die abgelaufen sind (expires_at < jetzt)
        $expiredStories = Story::where('expires_at', '<=', now())->get();
        $count = 0;

        foreach ($expiredStories as $story) {
            // Bilddatei lÃ¶schen
            $relativePath = str_replace('/storage/', '', $story->media_path);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }

            // Datenbankeintrag lÃ¶schen
            $story->delete();
            $count++;
        }

        $this->info("Erfolgreich {$count} abgelaufene Story(s) gelÃ¶scht.");
    }
}
