@extends('layouts.app')

@section('content')

    <h1 class="mb-10 text-2x1"> Add Review for {{ $book->title}} </h1>
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style=" color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf 
        <label for="review">Review </label>
        <textarea name="review" id="review" rows="4"  class="input required w-full mb-4">{{ old('review') }}</textarea> 

        <label for="rating">Rating</label>
        <select name="rating" id="rating" class="input mb-4 required">Select a Rating 
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" >{{ $i }}</option>
            @endfor
        </select>

        <button type="submit" class="btn">Add Review</button>
    </form>