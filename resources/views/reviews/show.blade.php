@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Review Details</h2>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Review Content</h3>
                <p class="text-gray-600">{{ $review->content }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Rating</h3>
                <p class="text-gray-600">{{ $review->rating }}/5</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Reviewer</h3>
                <p class="text-gray-600">{{ Auth::user()->name }}</p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('reviews.edit', $review) }}"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-500 transition">
                    Edit
                </a>

                <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this review?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-500 transition">
                        Delete
                    </button>
                </form>

                <a href="{{ route('reviews.index') }}"
                    class="px-4 py-2 bg-gray-300 text-black text-sm font-medium rounded hover:bg-gray-400 transition">
                    Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
