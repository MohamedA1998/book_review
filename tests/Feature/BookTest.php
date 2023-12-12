<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_home_page_to_book_page(): void
    {
        $response = $this->get('/')
            ->assertStatus(302)
            ->assertRedirect(route('book.index'));
    }

    public function test_see_no_books_found_when_not_book()
    {
        $response = $this->get('book')
            ->assertOk()
            ->assertViewHas('books')
            ->assertSee('No books found');
    }

    public function test_see_one_book_when_has_one_book()
    {
        $book = $this->CreateBook();

        $response = $this->get('book')
            ->assertOk()
            ->assertDontSee('No books found')
            ->assertSee($book->title)
            ->assertSee($book->UpperAuthor);

        $this->assertDatabaseCount('books', 1)
            ->assertModelExists($book);
    }

    public function test_see_book_when_dont_have_reviwes()
    {
        $book = $this->CreateBook();

        $response = $this->get('book')
            ->assertOk()
            ->assertSeeText("out of 0 reviews");
    }

    public function test_see_book_when_have_10_reviwes()
    {
        $book = $this->CreateBook(Review::factory()->count(10));

        $response = $this->get('book')
            ->assertOk()
            ->assertSeeText($book->title)
            ->assertSeeText("out of 10 reviews");

        $this->assertDatabaseCount('reviews', 10);
    }

    public function test_search_from_1_book_when_have_this_book()
    {
        $Book = Book::factory()->create([
            'title' => 'Hello This Test Book To Search',
        ]);

        $response = $this->get('book?title=Test+Book')
            ->assertOk()
            ->assertSeeText('Hello This Test Book To Search');
    }

    public function test_search_from_1_book_when_dont_have_this_book()
    {
        $Book = Book::factory()->create([
            'title' => 'Hello This Book To Search',
        ]);

        $response = $this->get('book?title=Test+Me')
            ->assertOk()
            ->assertSeeText('No books found');
    }

    private function CreateBook(object $hasRelashen = null)
    {
        return ($hasRelashen == null) ?
        Book::factory()->create() :
        Book::factory()->has($hasRelashen)->create();
    }

}
