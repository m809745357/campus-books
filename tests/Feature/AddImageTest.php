<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddImageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function only_members_can_add_file()
    {
        $this->withExceptionHandling();

        $this->json('POST', 'upload')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_file_must_be_provided()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $this->withExceptionHandling();

        $this->json('POST', 'upload', [
            'file' => 'not-an-file'
        ])->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_file_to_their_book()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        Storage::fake('public');

        $this->json('POST', 'upload', [
            'file' => $file = UploadedFile::fake()->image('image.jpg')
        ]);

        Storage::disk('public')->assertExists('books/' . $file->hashName());
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
