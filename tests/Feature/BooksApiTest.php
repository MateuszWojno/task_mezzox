<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->book = Book::factory(1)->create()[0];

        $this->createUsers();


    }

    public function test_admin_can_see_book()
    {
        $response = $this->actingAs($this->admin)->getJson(route('books.show', ['id' => $this->book->id]));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'title',
                'author',
                'publication_year',
                'publisher',
                'status',
                'borrower' => [
                    'first_name',
                    'last_name'
                ]
            ]
        ]);
    }

    public function test_user_can_see_book()
    {
        $response = $this->actingAs($this->user)->getJson(route('books.show', ['id' => $this->book->id]));
        $response->assertOk();
        $response->assertJsonStructure([
            'data'
        ]);
    }

    public function test_user_can_see_books()
    {
        $response = $this->actingAs($this->user)->getJson(route('books.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data'
        ]);
    }

    public function test_admin_can_see_books()
    {
        $response = $this->actingAs($this->admin)->getJson(route('books.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data'
        ]);
    }


}
