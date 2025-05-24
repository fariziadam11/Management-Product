@extends('layouts.app')

@section('page_heading', 'Create User')

@section('page_actions')
<a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-150 ease-in-out">
    <i class="bi bi-arrow-left mr-2"></i> Back to Users
</a>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="w-full">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-blue-600">User Information</h2>
            </div>
            <div class="p-4 sm:p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <!-- Basic Information -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                <input type="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('password') border-red-500 @enderror" id="password" name="password" required>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 px-3">
                            <div class="mb-4">
                                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                                <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('role_id') border-red-500 @enderror" id="role_id" name="role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('phone') border-red-500 @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="birthday" class="block text-sm font-medium text-gray-700 mb-1">Birthday</label>
                                <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('birthday') border-red-500 @enderror" id="birthday" name="birthday" value="{{ old('birthday') }}">
                                @error('birthday')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="radio" name="is_active" id="statusActive" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                        <label class="ml-2 text-sm text-gray-700" for="statusActive">Active</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="radio" name="is_active" id="statusInactive" value="0" {{ old('is_active') == '0' ? 'checked' : '' }}>
                                        <label class="ml-2 text-sm text-gray-700" for="statusInactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="w-full px-3">
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('notes') border-red-500 @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="w-full px-3">
                            <hr class="my-6 border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button type="reset" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-150 ease-in-out">Reset</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out">Create User</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password strength validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        passwordInput.addEventListener('input', function() {
            validatePassword();
        });

        confirmPasswordInput.addEventListener('input', function() {
            validatePasswordMatch();
        });

        function validatePassword() {
            const password = passwordInput.value;
            let strength = 0;

            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]+/)) strength += 1;

            const feedbackElement = document.createElement('div');
            feedbackElement.className = 'password-strength mt-1 text-sm';

            switch(strength) {
                case 0:
                case 1:
                    feedbackElement.innerHTML = '<span class="text-red-500">Very Weak</span>';
                    break;
                case 2:
                    feedbackElement.innerHTML = '<span class="text-yellow-500">Weak</span>';
                    break;
                case 3:
                    feedbackElement.innerHTML = '<span class="text-blue-400">Medium</span>';
                    break;
                case 4:
                    feedbackElement.innerHTML = '<span class="text-blue-600">Strong</span>';
                    break;
                case 5:
                    feedbackElement.innerHTML = '<span class="text-green-500">Very Strong</span>';
                    break;
            }

            const existingFeedback = passwordInput.parentNode.querySelector('.password-strength');
            if (existingFeedback) {
                passwordInput.parentNode.removeChild(existingFeedback);
            }

            passwordInput.parentNode.appendChild(feedbackElement);
        }

        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            const feedbackElement = document.createElement('div');
            feedbackElement.className = 'password-match mt-1 text-sm';

            if (confirmPassword === '') {
                feedbackElement.innerHTML = '';
            } else if (password === confirmPassword) {
                feedbackElement.innerHTML = '<span class="text-green-500">Passwords match</span>';
            } else {
                feedbackElement.innerHTML = '<span class="text-red-500">Passwords do not match</span>';
            }

            const existingFeedback = confirmPasswordInput.parentNode.querySelector('.password-match');
            if (existingFeedback) {
                confirmPasswordInput.parentNode.removeChild(existingFeedback);
            }

            confirmPasswordInput.parentNode.appendChild(feedbackElement);
        }
    });
</script>
@endsection
