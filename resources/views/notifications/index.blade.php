@extends('layouts.app')

@section('page_heading', 'Notifications')

@section('content')
<div class="w-full">
    <div class="flex flex-col">
        <div class="w-full max-w-5xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-blue-600">All Notifications</h2>
                    <div>
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="bi bi-check-all mr-1.5"></i> Mark All as Read
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                            <button class="tab-button whitespace-nowrap py-3 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 focus:outline-none"
                                id="unread-tab"
                                data-tab="unread"
                                aria-controls="unread"
                                aria-selected="true">
                                Unread <span class="ml-1.5 py-0.5 px-2 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </button>
                            <button class="tab-button whitespace-nowrap py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none"
                                id="read-tab"
                                data-tab="read"
                                aria-controls="read"
                                aria-selected="false">
                                Read <span class="ml-1.5 py-0.5 px-2 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ auth()->user()->readNotifications->count() }}</span>
                            </button>
                            <button class="tab-button whitespace-nowrap py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none"
                                id="all-tab"
                                data-tab="all"
                                aria-controls="all"
                                aria-selected="false">
                                All <span class="ml-1.5 py-0.5 px-2 text-xs font-medium rounded-full bg-gray-100 text-gray-800">{{ auth()->user()->notifications->count() }}</span>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="mt-6">
                        <!-- Unread Notifications -->
                        <div class="tab-content" id="unread" role="tabpanel" aria-labelledby="unread-tab">
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <div class="space-y-3">
                                    @foreach(auth()->user()->unreadNotifications as $notification)
                                        <div class="bg-blue-50 border border-blue-100 rounded-lg overflow-hidden">
                                            <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                                @if($notification->type == 'App\\Notifications\\ExportReady')
                                                    <div class="flex items-start sm:items-center">
                                                        <div class="mr-4 flex-shrink-0">
                                                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                                                                <i class="bi bi-download text-white text-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-medium text-gray-900">{{ $notification->data['message'] }}</h3>
                                                            <p class="text-sm text-gray-500">{{ ucfirst($notification->data['type']) }} export is ready for download</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3 ml-14 sm:ml-0">
                                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                        <div class="flex gap-2">
                                                            <a href="{{ route('export.download', basename($notification->data['file_path'])) }}"
                                                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                                <i class="bi bi-download mr-1.5"></i> Download
                                                            </a>
                                                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center px-2 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                                    <i class="bi bi-check"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-md bg-blue-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-info-circle text-blue-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">You have no unread notifications.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Read Notifications -->
                        <div class="tab-content hidden" id="read" role="tabpanel" aria-labelledby="read-tab">
                            @if(auth()->user()->readNotifications->count() > 0)
                                <div class="space-y-3">
                                    @foreach(auth()->user()->readNotifications as $notification)
                                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                            <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                                @if($notification->type == 'App\\Notifications\\ExportReady')
                                                    <div class="flex items-start sm:items-center">
                                                        <div class="mr-4 flex-shrink-0">
                                                            <div class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center">
                                                                <i class="bi bi-download text-white text-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-medium text-gray-900">{{ $notification->data['message'] }}</h3>
                                                            <p class="text-sm text-gray-500">{{ ucfirst($notification->data['type']) }} export is ready for download</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3 ml-14 sm:ml-0">
                                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                        <a href="{{ route('export.download', basename($notification->data['file_path'])) }}"
                                                           class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                            <i class="bi bi-download mr-1.5"></i> Download
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-md bg-blue-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-info-circle text-blue-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">You have no read notifications.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- All Notifications -->
                        <div class="tab-content hidden" id="all" role="tabpanel" aria-labelledby="all-tab">
                            @if(auth()->user()->notifications->count() > 0)
                                <div class="space-y-3">
                                    @foreach(auth()->user()->notifications as $notification)
                                        <div class="{{ $notification->read_at ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-100' }} border rounded-lg overflow-hidden">
                                            <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                                @if($notification->type == 'App\\Notifications\\ExportReady')
                                                    <div class="flex items-start sm:items-center">
                                                        <div class="mr-4 flex-shrink-0">
                                                            <div class="h-10 w-10 rounded-full {{ $notification->read_at ? 'bg-gray-400' : 'bg-blue-600' }} flex items-center justify-center">
                                                                <i class="bi bi-download text-white text-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-medium text-gray-900">{{ $notification->data['message'] }}</h3>
                                                            <p class="text-sm text-gray-500">{{ ucfirst($notification->data['type']) }} export is ready for download</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3 ml-14 sm:ml-0">
                                                        <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                        <a href="{{ route('export.download', basename($notification->data['file_path'])) }}"
                                                           class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                            <i class="bi bi-download mr-1.5"></i> Download
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-md bg-blue-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-info-circle text-blue-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">You have no notifications.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');

                // Update button states
                tabButtons.forEach(btn => {
                    if (btn.getAttribute('data-tab') === tabId) {
                        btn.classList.remove('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300');
                        btn.classList.add('border-blue-500', 'text-blue-600');
                        btn.setAttribute('aria-selected', 'true');
                    } else {
                        btn.classList.remove('border-blue-500', 'text-blue-600');
                        btn.classList.add('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300');
                        btn.setAttribute('aria-selected', 'false');
                    }
                });

                // Show selected tab content
                tabContents.forEach(content => {
                    if (content.id === tabId) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
