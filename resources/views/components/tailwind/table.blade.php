@props([
    'headers' => [],
    'sortable' => false,
    'striped' => false,
    'hover' => true,
    'responsive' => true,
    'compact' => false,
    'bordered' => false,
    'rounded' => true,
    'id' => null
])

@php
// Generate a unique ID if not provided
$tableId = $id ?? 'table-' . md5(json_encode($headers) . rand());

// Base classes
$baseClasses = 'min-w-full divide-y divide-gray-200';
if ($bordered) {
    $baseClasses .= ' border border-gray-200';
}
if ($rounded) {
    $baseClasses .= ' rounded-lg overflow-hidden';
}

// Wrapper classes
$wrapperClasses = 'bg-white shadow-sm';
if ($rounded) {
    $wrapperClasses .= ' rounded-lg';
}
if ($responsive) {
    $wrapperClasses .= ' overflow-x-auto';
}

// Row classes
$rowBaseClasses = '';
if ($hover) {
    $rowBaseClasses .= ' hover:bg-gray-50 transition-colors duration-150';
}

// Cell classes
$cellClasses = $compact ? 'px-4 py-2' : 'px-6 py-4';
@endphp

<div x-data="dataTable()" x-cloak class="{{ $wrapperClasses }} table-responsive-wrapper">
    <table id="{{ $tableId }}" class="{{ $baseClasses }}">
        @if(count($headers) > 0)
        <thead class="bg-gray-50">
            <tr>
                @foreach($headers as $key => $header)
                <th scope="col"
                    @if($sortable)
                    @click="sortBy('{{ is_string($key) ? $key : $header }}')"
                    class="{{ $compact ? 'px-4 py-2' : 'px-6 py-3' }} text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer select-none"
                    @else
                    class="{{ $compact ? 'px-4 py-2' : 'px-6 py-3' }} text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    @endif
                >
                    <div class="flex items-center space-x-1">
                        <span>{{ is_string($key) ? $header : $header }}</span>
                        @if($sortable)
                        <span class="text-gray-400">
                            <template x-if="sortField === '{{ is_string($key) ? $key : $header }}' && sortDirection === 'asc'">
                                <i class="bi bi-sort-up"></i>
                            </template>
                            <template x-if="sortField === '{{ is_string($key) ? $key : $header }}' && sortDirection === 'desc'">
                                <i class="bi bi-sort-down"></i>
                            </template>
                            <template x-if="sortField !== '{{ is_string($key) ? $key : $header }}'">
                                <i class="bi bi-filter text-gray-300"></i>
                            </template>
                        </span>
                        @endif
                    </div>
                </th>
                @endforeach
            </tr>
        </thead>
        @endif

        <tbody class="bg-white divide-y divide-gray-200">
            {{ $slot }}
        </tbody>

        @if(isset($footer))
        <tfoot class="bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </tfoot>
        @endif
    </table>

    <!-- Empty State -->
    <div x-show="isEmpty" class="w-full py-12 flex flex-col items-center justify-center text-center">
        <div class="rounded-full bg-gray-100 p-3 mb-4">
            <i class="bi bi-table text-gray-400 text-xl"></i>
        </div>
        <h3 class="text-sm font-medium text-gray-900">No items found</h3>
        <p class="text-sm text-gray-500 mt-1">{{ $emptyMessage ?? 'There are no items to display.' }}</p>
    </div>
</div>

@once
@push('scripts')
<script>
    function dataTable() {
        return {
            sortField: null,
            sortDirection: 'asc',
            isEmpty: false,

            init() {
                // Check if table is empty
                const table = document.getElementById('{{ $tableId }}');
                if (table) {
                    const tbody = table.querySelector('tbody');
                    this.isEmpty = tbody && tbody.children.length === 0;

                    // Fix responsive table layout
                    this.fixTableLayout(table);
                }

                // Listen for window resize to adjust table layout
                window.addEventListener('resize', () => this.fixTableLayout(table));
            },

            fixTableLayout(table) {
                if (!table) return;

                // Get the wrapper and ensure it has proper styling
                const wrapper = table.closest('.table-responsive-wrapper');
                if (wrapper) {
                    // Make sure wrapper has proper display and width
                    wrapper.style.display = 'block';
                    wrapper.style.width = '100%';

                    // Check for horizontal overflow
                    const hasOverflow = table.offsetWidth > wrapper.offsetWidth;
                    if (hasOverflow) {
                        wrapper.classList.add('has-horizontal-scroll');
                    } else {
                        wrapper.classList.remove('has-horizontal-scroll');
                    }
                }
            },

            sortBy(field) {
                if (this.sortField === field) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortField = field;
                    this.sortDirection = 'asc';
                }

                // Emit a custom event for external sorting
                this.$dispatch('sort-table', {
                    field: this.sortField,
                    direction: this.sortDirection,
                    tableId: '{{ $tableId }}'
                });
            }
        };
    }
</script>
@endpush
@endonce
