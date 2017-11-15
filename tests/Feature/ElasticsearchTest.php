<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElasticsearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function elasticsearch_can_import_books()
    // {
    //     $book = factory('App\Models\Book')->create(['title' => 'hello']);
    //
    //     $es = \App\Models\Book::search('hello')->get()->toArray();
    //
    //     $this->assertEquals($book->title, $es['0']['title']);
    // }

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
