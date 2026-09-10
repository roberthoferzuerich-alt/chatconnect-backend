<?php

namespace Tests\Feature;

use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_story_index_page_is_accessible(): void
    {
        $response = $this->get(route('stories.index'));

        $response->assertStatus(200);
        $response->assertSee('Meine Storys');
        $response->assertSee('Keine kürzlichen');
    }

    public function test_story_camera_create_page_is_accessible(): void
    {
        $response = $this->get(route('stories.create'));

        $response->assertStatus(200);
        $response->assertSee('Foto');
    }

    public function test_user_can_upload_and_create_story(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('story.jpg');

        $response = $this->actingAs($user)->post(route('stories.store'), [
            'photo' => $file,
            'caption' => 'Mein erstes Foto',
        ]);

        $response->assertRedirect(route('stories.index'));
        $this->assertDatabaseHas('stories', [
            'user_id' => $user->id,
            'caption' => 'Mein erstes Foto',
        ]);
    }

    public function test_user_can_delete_story(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $story = Story::create([
            'user_id' => $user->id,
            'image_path' => 'stories/test.jpg',
            'views_count' => 0,
        ]);

        $response = $this->actingAs($user)->delete(route('stories.destroy', $story));

        $response->assertRedirect(route('stories.detail'));
        $this->assertDatabaseMissing('stories', [
            'id' => $story->id,
        ]);
    }
}
