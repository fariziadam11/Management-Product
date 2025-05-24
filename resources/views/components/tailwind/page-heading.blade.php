<!-- Page Heading -->
@if(View::hasSection('page_heading'))
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">@yield('page_heading')</h1>
    @if(View::hasSection('page_actions'))
        <div class="page-actions">@yield('page_actions')</div>
    @endif
</div>
@endif
