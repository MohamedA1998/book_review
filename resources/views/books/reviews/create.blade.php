@extends('layout.app')
@section('content')
    <h1 class="mb-10 text-2xl">Add Review for {{ $book->title }}</h1>

    <form method="post" action="{{ route('book.review.store', $book) }}">
        @csrf
        <label for="review">Review</label>
        @error('review'){{ $message }}@enderror
        <textarea name="review" id="review" required class="input mb-4"></textarea>
        <label for="rating">Rating</label>
        <select name="rating" id="rating" class="input mb-4" required>
            <option value="">Select a Rating</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        <button type="submit" class="btn">Add Review</button>
    </form>
@endsection