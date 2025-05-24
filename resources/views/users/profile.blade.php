@extends('layouts.app')

@section('page_heading', 'User Profile')

@section('content')
<div class="container mx-auto px-4 max-w-7xl">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full xl:w-1/3 px-4">
            <!-- Profile picture card -->
            <div class="bg-white rounded-lg shadow-lg mb-4 xl:mb-0">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600 m-0">Profile Picture</h6>
                </div>
                <div class="p-6 text-center">
                    <!-- Profile picture image -->
                    <img class="rounded-full mx-auto mb-4 w-32 h-32 sm:w-36 sm:h-36 md:w-40 md:h-40" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff&size=150" alt="{{ $user->name }}">
                    <!-- Profile picture help block -->
                    <div class="text-sm text-gray-500 italic mb-4">{{ $user->name }}</div>
                    <!-- Profile picture upload button -->
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200" type="button">Upload new image</button>
                </div>
            </div>

            <!-- Role information card -->
            <div class="bg-white rounded-lg shadow-lg my-4">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600 m-0">Role Information</h6>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-sm text-gray-500 mb-1">Current Role</div>
                        <div class="text-xl">
                            @if($user->role)
                                <span class="inline-block bg-blue-600 text-white text-sm font-medium px-3 py-1 rounded-full">{{ $user->role->name }}</span>
                            @else
                                <span class="inline-block bg-gray-500 text-white text-sm font-medium px-3 py-1 rounded-full">No Role Assigned</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-sm text-gray-500 mb-1">Account Created</div>
                        <div class="text-gray-800">{{ $user->created_at->format('F d, Y') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Last Updated</div>
                        <div class="text-gray-800">{{ $user->updated_at->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full xl:w-2/3 px-4">
            <!-- Account details card -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600 m-0">Account Details</h6>
                </div>
                <div class="p-6">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Form Group (name) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="name">Full Name</label>
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="name" name="name" type="text" placeholder="Enter your full name" value="{{ $user->name }}">
                        </div>

                        <!-- Form Group (email address) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email address</label>
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ $user->email }}">
                        </div>

                        <!-- Form Row -->
                        <div class="flex flex-wrap -mx-2 mb-4">
                            <!-- Form Group (phone number) -->
                            <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="phone">Phone number</label>
                                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="phone" name="phone" type="tel" placeholder="Enter your phone number" value="{{ $user->phone ?? '' }}">
                            </div>
                            <!-- Form Group (birthday) -->
                            <div class="w-full md:w-1/2 px-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="birthday">Birthday</label>
                                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="birthday" name="birthday" type="date" placeholder="Enter your birthday" value="{{ $user->birthday ?? '' }}">
                            </div>
                        </div>

                        <!-- Save changes button -->
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200" type="submit">Save changes</button>
                    </form>
                </div>
            </div>

            <!-- Security card -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600 m-0">Security</h6>
                </div>
                <div class="p-6">
                    <form action="{{ route('users.password', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Form Group (current password) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="current_password">Current Password</label>
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="current_password" name="current_password" type="password" placeholder="Enter current password">
                        </div>

                        <!-- Form Group (new password) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="password">New Password</label>
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="password" name="password" type="password" placeholder="Enter new password">
                        </div>

                        <!-- Form Group (confirm password) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">Confirm Password</label>
                            <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password">
                        </div>

                        <!-- Save changes button -->
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200" type="submit">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="flex flex-wrap -mx-4">
        <div class="w-full px-4">
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600 m-0">Your Recent Reviews</h6>
                </div>
                <div class="p-6">
                    @if(count($user->reviews) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-medium text-gray-700">Product</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-medium text-gray-700">Rating</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-medium text-gray-700">Title</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach($user->reviews as $review)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">{{ $review->product->name }}</td>
                                        <td class="border border-gray-300 px-4 py-3 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="bi bi-star-fill text-yellow-400"></i>
                                                @else
                                                    <i class="bi bi-star text-yellow-400"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">{{ $review->title }}</td>
                                        <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">{{ $review->created_at->format('M d, Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-3 text-sm">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('reviews.edit', $review->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded transition duration-200">
                                                    <i class="bi bi-pencil text-xs"></i>
                                                </a>
                                                <a href="{{ route('reviews.show', $review->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-cyan-600 hover:bg-cyan-700 text-white rounded transition duration-200">
                                                    <i class="bi bi-eye text-xs"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500">You haven't written any reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
