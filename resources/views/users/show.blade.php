@extends('layouts.app')

@section('page_heading', 'User Details')

@section('page_actions')
<div class="flex space-x-2">
    @can('edit users')
    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out">
        <i class="bi bi-pencil mr-2"></i> Edit User
    </a>
    @endcan
    <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-150 ease-in-out">
        <i class="bi bi-arrow-left mr-2"></i> Back to List
    </a>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/3 px-4 mb-6 lg:mb-0">
            <!-- User card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-600">User Information</h2>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="text-center mb-6">
                        <img class="h-32 w-32 rounded-full mx-auto mb-3 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff&size=200" alt="{{ $user->name }}">
                        <h3 class="text-xl font-medium text-gray-900">{{ $user->name }}</h3>
                        <div class="text-gray-500 mb-2">{{ $user->email }}</div>
                        <div class="flex justify-center space-x-2">
                            @if($user->role)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $user->role->name }}</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">No Role</span>
                            @endif
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <div class="py-3">
                            <div class="flex justify-between">
                                <div class="text-sm font-medium text-gray-500">User ID:</div>
                                <div class="text-sm text-gray-900">{{ $user->id }}</div>
                            </div>
                        </div>
                        <div class="py-3">
                            <div class="flex justify-between">
                                <div class="text-sm font-medium text-gray-500">UUID:</div>
                                <div class="text-sm text-gray-900 break-all">{{ $user->uuid }}</div>
                            </div>
                        </div>
                        <div class="py-3">
                            <div class="flex justify-between">
                                <div class="text-sm font-medium text-gray-500">Created:</div>
                                <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="py-3">
                            <div class="flex justify-between">
                                <div class="text-sm font-medium text-gray-500">Last Updated:</div>
                                <div class="text-sm text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="py-3">
                            <div class="flex justify-between">
                                <div class="text-sm font-medium text-gray-500">Last Login:</div>
                                <div class="text-sm text-gray-900">
                                    @if($user->last_login_at)
                                        {{ \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y H:i') }}
                                    @else
                                        <span class="text-gray-500">Never</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 px-4">
            <!-- Activity card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-600">Recent Activity</h2>
                </div>
                <div class="p-4 sm:p-6">
                    @if(count($user->audits) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->audits->take(10) as $audit)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $audit->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($audit->event == 'created')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Created</span>
                                                @elseif($audit->event == 'updated')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Updated</span>
                                                @elseif($audit->event == 'deleted')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Deleted</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($audit->event) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @if($audit->event == 'updated')
                                                    <ul class="list-none space-y-1 m-0 p-0">
                                                        @foreach($audit->getModified() as $field => $values)
                                                            <li>
                                                                <span class="font-medium">{{ ucfirst($field) }}</span>: 
                                                                @if(is_array($values['old']))
                                                                    Changed
                                                                @else
                                                                    {{ Str::limit($values['old'], 20) }} → {{ Str::limit($values['new'], 20) }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ ucfirst($audit->event) }} {{ class_basename($audit->auditable_type) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-6">
                            <a href="{{ route('audits.model', ['type' => 'users', 'id' => $user->id]) }}" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                View All Activity
                            </a>
                        </div>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">No activity records found for this user.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-blue-600">Product Reviews</h2>
                </div>
                <div class="p-4 sm:p-6">
                    @if(count($user->reviews) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->reviews->take(5) as $review)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('products.show', $review->product_id) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $review->product->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }} mr-0.5"></i>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($review->comment, 50) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(count($user->reviews) > 5)
                            <div class="text-center mt-6">
                                <a href="{{ route('reviews.index', ['user_id' => $user->id]) }}" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    View All Reviews
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">No reviews submitted by this user.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
