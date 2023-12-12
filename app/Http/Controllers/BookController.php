<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

// You Should Use Lazy Loading When You Are Working With A Small Number Of Records
// And You Know You Dont Need To Worry About The Performance
class BookController extends Controller
{

    public function index(Request $request)
    {
        $RequestTitle = $request->input('title');

        $RequestFilter = $request->input('filter', '');

        $books = Book::when($RequestTitle, fn($query) => $query->WhereTitleLike($RequestTitle));

        $books = match ($RequestFilter) {
            'popular_last_month' => $books->PopularLastMonth(),
            'popular_last_6months' => $books->PopularLast6Month(),
            'highest_rated_last_month' => $books->HighestRatedLastMonth(),
            'highest_rated_last_6months' => $books->HighestRatedLast6Month(),
            default => $books->latest()->WithAvgRating()->WithCountReviews()
        };

        $books = cache()->remember("Books:{$RequestFilter}:{$RequestTitle}", 3600, fn() => $books->get());

        return view('books.index', [
            'books' => empty($RequestFilter) ? $books->paginate(15) : $books->get(),
        ]);
    }

    public function show(int $id) //Book $book
    {
        $book = cache()->remember("book:{$id}", 3600, fn() => Book::with([
            'reviews' => fn($q) => $q->latest(),
        ])->WithCountReviews()->WithAvgRating()->findOrFail($id));

        return view('books.show', ['book' => $book]);
    }
}
