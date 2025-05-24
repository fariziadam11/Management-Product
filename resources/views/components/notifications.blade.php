@php
if (auth()->check()) {
    $notifications = auth()->user()->unreadNotifications ?? collect();
} else {
    $notifications = collect();
}
@endphp

@if($notifications->count() > 0)
    <div class="py-2 px-4 text-xs font-medium text-gray-500 bg-gray-100 border-b border-gray-200">Notifications Center</div>
    @foreach($notifications as $notification)
        @if($notification->type == 'App\\Notifications\\ExportReady')
            <a class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150"
               href="{{ route('export.download', basename($notification->data['file_path'])) }}"
               onclick="event.preventDefault(); document.getElementById('mark-read-{{ $notification->id }}').submit();">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
                            <i class="bi bi-download text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div class="text-xs text-gray-500 mb-1">{{ $notification->created_at->diffForHumans() }}</div>
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $notification->data['message'] }}</p>
                    </div>
                </div>
            </a>
            <form id="mark-read-{{ $notification->id }}" action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="hidden">
                @csrf
            </form>
        @endif
    @endforeach
    <a class="block py-2 text-xs text-center text-gray-500 hover:text-gray-700 border-t border-gray-200 hover:bg-gray-50 transition-colors duration-150"
       href="{{ route('notifications.index') }}">Show All Notifications</a>
@else
    <div class="py-3 px-4 text-sm text-center text-gray-500">No new notifications</div>
@endif
