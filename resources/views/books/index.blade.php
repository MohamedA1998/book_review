@extends('layout.app')

@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>

    <form action="{{ route('book.index') }}" method="get" class="mb-4 flex items-center space-x-2">
        <input type="text" name="title" class="input h-10" placeholder="Search By Title" value="{{ request('title') }}" />
        <input type="hidden" name="filter" value="{{ request('filter') }}" />
        <input type="submit" value="Search" class="btn h-10">
        <a href="{{ route('book.index') }}" class="btn h-10">Clear</a>
    </form>

    <div class="filter-container mb-4 flex">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Months',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
            ];
        @endphp


        @foreach ($filters as $key => $label)
            <a href="{{ route('book.index', [...request()->query(), 'filter' => $key]) }}"
                class="{{ request('filter') === $key || (request('filter') === null && $key === '')
                    ? 'filter-item-active'
                    : 'filter-item' }}">
                {{ $label }}
            </a>
        @endforeach

    </div>

    @forelse ($books as $book)
        <ul>
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('book.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->UpperAuthor }}</span>
                        </div>
                        <div>
                            <div class="book-rating">

                                <x-star-rating :rating="$book->reviews_avg_rating" />

                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    @empty

        <ul>
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="#" class="reset-link">Reset criteria</a>
                </div>
            </li>
        </ul>
    @endforelse

    @if (request('filter') == '')
        {{ $books->links() }}
    @endif
@endsection
