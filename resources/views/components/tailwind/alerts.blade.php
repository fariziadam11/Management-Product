<!-- Alerts -->
@if (session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6" role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="bi bi-check-circle-fill text-green-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" data-bs-dismiss="alert">
                    <span class="sr-only">Dismiss</span>
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6" role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" data-bs-dismiss="alert">
                    <span class="sr-only">Dismiss</span>
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
