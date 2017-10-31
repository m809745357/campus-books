<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnnexTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function only_members_can_view_onwer_preview_annex()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id, 'type' => 'EBook', 'annex' => '']);

        $this->get($book->path() . '/annex')->assertSee($book->cover);

        $otherBook = factory('App\Models\Book')->create(['type' => 'EBook']);

        $this->get($otherBook->path() . '/annex')->assertStatus(302);
    }

    /** @test */
    public function only_ebook_has_preview_annex()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id, 'type' => 'PBook', 'annex' => '']);

        $this->get($book->path() . '/annex')->assertStatus(302);
    }

    /** @test */
    public function only_members_can_download_annex()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id, 'type' => 'EBook', 'annex' => '']);

        $this->get($book->path() . '/annex/download');

        Storage::disk('public')->assertExists('books/annex/book' . $book->id . '.pdf');

        $otherBook = factory('App\Models\Book')->create(['user_id' => $user->id, 'type' => 'EBook', 'annex' => 'https://www.baidu.com']);

        $response = $this->get($otherBook->path() . '/annex/download');

        $this->assertEquals('https://www.baidu.com', $response->headers->get('Location'));
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
