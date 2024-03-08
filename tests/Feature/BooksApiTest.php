<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();
        $this->book = Book::factory()->create();

        $this->createUsers();


    }

    public function test_admin_can_see_book()
    {

        $this->book->borrower_id = $this->customer->id;
        $this->book->update(['status' => 'unav']);
        $this->book->save();

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
        $this->book->borrower_id = $this->customer->id;
        $this->book->update(['status' => 'unav']);
        $this->book->save();

        $response = $this->actingAs($this->user)->getJson(route('books.show', ['id' => $this->book->id]));
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

    public function test_admin_can_borrow_book()
    {
        $this->book->update(['status' => 'av']);
        $response = $this->actingAs($this->admin)->postJson(route('customers.borrow-book', ['customerId' => $this->customer->id, 'bookId' => $this->book->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'title',
                'author',
                'publication_year',
                'publisher',
                'status',
            ]
        ]);
        $response->assertJsonFragment([
            'status' => 'unav',
        ]);

        $this->assertDatabaseHas('books', ['id' => $this->book->id, 'borrower_id' => $this->customer->id]);
    }

    public function test_user_can_borrow_book()
    {
        $this->book->update(['status' => 'av']);
        $response = $this->actingAs($this->user)->postJson(route('customers.borrow-book', ['customerId' => $this->customer->id, 'bookId' => $this->book->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'title',
                'author',
                'publication_year',
                'publisher',
                'status',
            ]
        ]);
        $response->assertJsonFragment([
            'status' => 'unav',
        ]);

        $this->assertDatabaseHas('books', ['id' => $this->book->id, 'borrower_id' => $this->customer->id]);
    }

    public function test_admin_can_return_book()
    {

        $this->book->borrower_id = $this->customer->id;
        $this->book->update(['status' => 'unav']);
        $this->book->save();

        $response = $this->actingAs($this->admin)->postJson(route('customers.return-book', ['customerId' => $this->customer->id, 'bookId' => $this->book->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'title',
                'author',
                'publication_year',
                'publisher',
                'status',
            ]
        ]);
        $response->assertJsonFragment([
            'status' => 'av',
        ]);

        $this->assertDatabaseHas('books', ['id' => $this->book->id, 'borrower_id' => null]);
    }

    public function test_user_can_return_book()
    {

        $this->book->borrower_id = $this->customer->id;
        $this->book->update(['status' => 'unav']);
        $this->book->save();

        $response = $this->actingAs($this->user)->postJson(route('customers.return-book', ['customerId' => $this->customer->id, 'bookId' => $this->book->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'title',
                'author',
                'publication_year',
                'publisher',
                'status',
            ]
        ]);
        $response->assertJsonFragment([
            'status' => 'av',
        ]);

        $this->assertDatabaseHas('books', ['id' => $this->book->id, 'borrower_id' => null]);
    }


    public function test_that_admin_can_search_book_via_title()
    {

        $response = $this->actingAs($this->admin)->getJson(route('books.search', [
            'search' => substr($this->book->title, 0, 3)
        ]));

        $this->assertTrue(
            count($response->json()) > 0
        );
    }

    public function test_that_user_can_search_book_via_title()
    {

        $response = $this->actingAs($this->user)->getJson(route('books.search', [
            'search' => substr($this->book->title, 0, 3)
        ]));

        $this->assertTrue(
            count($response->json()) > 0
        );
    }

    public function test_that_admin_can_search_book_via_author()
    {

        $response = $this->actingAs($this->admin)->getJson(route('books.search', [
            'search' => substr($this->book->author, 0, 3)
        ]));

        $this->assertTrue(
            count($response->json()) > 0
        );
    }

    public function test_that_user_can_search_book_via_author()
    {

        $response = $this->actingAs($this->admin)->getJson(route('books.search', [
            'search' => substr($this->book->author, 0, 3)
        ]));

        $this->assertTrue(
            count($response->json()) > 0
        );
    }



}
