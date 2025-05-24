@extends('layouts.app')

@section('page_heading', 'Analytics Dashboard')

@section('content')
<div class="w-full space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Total Products Card -->
        <x-tailwind.card variant="primary">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-blue-600 uppercase mb-1">Total Products</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</div>
                    <div class="mt-2">
                        <x-tailwind.badge variant="success" size="sm" icon="arrow-up">
                            {{ $productGrowth }}% since last month
                        </x-tailwind.badge>
                    </div>
                </div>
                <div class="text-gray-300">
                    <i class="bi bi-box text-4xl"></i>
                </div>
            </div>
        </x-tailwind.card>

        <!-- Total Revenue Card -->
        <x-tailwind.card variant="success">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-green-600 uppercase mb-1">Total Revenue</div>
                    <div class="text-2xl font-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="mt-2">
                        <x-tailwind.badge variant="success" size="sm" icon="arrow-up">
                            {{ $revenueGrowth }}% since last month
                        </x-tailwind.badge>
                    </div>
                </div>
                <div class="text-gray-300">
                    <i class="bi bi-currency-dollar text-4xl"></i>
                </div>
            </div>
        </x-tailwind.card>

        <!-- Average Rating Card -->
        <x-tailwind.card variant="info">
            <div class="flex items-center justify-between">
                <div class="w-full">
                    <div class="text-xs font-bold text-cyan-600 uppercase mb-1">Average Rating</div>
                    <div class="flex items-center mb-2">
                        <div class="text-2xl font-bold text-gray-800 mr-3">{{ number_format($averageRating, 1) }}</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-cyan-500 h-2 rounded-full" style="width: {{ ($averageRating / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <x-tailwind.badge variant="info" size="sm" icon="star-fill">
                            Based on {{ $totalReviews }} reviews
                        </x-tailwind.badge>
                    </div>
                </div>
                <div class="text-gray-300 ml-4">
                    <i class="bi bi-star-fill text-4xl"></i>
                </div>
            </div>
        </x-tailwind.card>

        <!-- Low Stock Items Card -->
        <x-tailwind.card variant="warning">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Low Stock Items</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $lowStockCount }}</div>
                    <div class="mt-2">
                        <x-tailwind.badge variant="danger" size="sm" icon="exclamation-triangle">
                            Requires attention
                        </x-tailwind.badge>
                    </div>
                </div>
                <div class="text-gray-300">
                    <i class="bi bi-exclamation-circle text-4xl"></i>
                </div>
            </div>
        </x-tailwind.card>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sales Chart -->
        <div class="lg:col-span-2">
            <x-tailwind.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-blue-600">Sales Overview</h3>
                        <x-tailwind.dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Export Data
                                </a>
                            </x-slot>
                        </x-tailwind.dropdown>
                    </div>
                </x-slot>
                <div class="h-80 w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </x-tailwind.card>
        </div>

        <!-- Category Distribution -->
        <div class="lg:col-span-1">
            <x-tailwind.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-blue-600">Category Distribution</h3>
                        <x-tailwind.dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Export Data
                                </a>
                            </x-slot>
                        </x-tailwind.dropdown>
                    </div>
                </x-slot>
                <div class="h-64 w-full">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="mt-4 flex flex-wrap justify-center gap-3 text-sm">
                    @foreach($categoryStats as $category)
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category['color'] ?? '#cccccc' }}"></span>
                            <span>{{ $category['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </x-tailwind.card>
        </div>
    </div>

    <!-- Recent Activity and Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentActivity as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($activity['user']) }}&background=4e73df&color=ffffff&size=24" alt="{{ $activity['user'] }}">
                                            <span class="text-sm font-medium text-gray-900">{{ $activity['user'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($activity['action'] == 'created')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Created</span>
                                        @elseif($activity['action'] == 'updated')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Updated</span>
                                        @elseif($activity['action'] == 'deleted')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Deleted</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $activity['action'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity['item'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity['time'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-blue-600">Top Products</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($topProducts as $index => $product)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <div class="relative">
                                    @if($product['image'])
                                        <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-12 h-12 rounded object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center">
                                            <i class="bi bi-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="absolute -top-1 -left-1 w-5 h-5 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product['name'] }}</h4>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ $product['category'] }}</span>
                                    <span class="text-sm font-medium text-blue-600">${{ number_format($product['price'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="border-t border-gray-200"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Category chart colors */
    .category-color-0 { color: #4e73df; }
    .category-color-1 { color: #1cc88a; }
    .category-color-2 { color: #36b9cc; }
    .category-color-3 { color: #f6c23e; }
    .category-color-4 { color: #e74a3b; }
    .category-color-5 { color: #5a5c69; }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        var salesCtx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesChartData['labels']) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($salesChartData['data']) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: 'rgba(59, 130, 246, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointHoverBorderColor: 'rgba(59, 130, 246, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    },
                    y: {
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return '$' + value;
                            }
                        },
                        grid: {
                            color: "rgb(243, 244, 246)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyColor: "#6b7280",
                        titleMarginBottom: 10,
                        titleColor: '#374151',
                        titleFontSize: 14,
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += '$' + context.parsed.y.toFixed(2);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Category Chart
        var categoryCtx = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_column($categoryStats, 'name')) !!},
                datasets: [{
                    data: {!! json_encode(array_column($categoryStats, 'count')) !!},
                    backgroundColor: ['#3b82f6', '#10b981', '#06b6d4', '#f59e0b', '#ef4444', '#6b7280'],
                    hoverBackgroundColor: ['#2563eb', '#059669', '#0891b2', '#d97706', '#dc2626', '#4b5563'],
                    hoverBorderColor: "rgba(243, 244, 246, 1)",
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyColor: "#6b7280",
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false
                    }
                }
            }
        });

        // Initialize Alpine.js dropdowns
        window.Alpine = Alpine;
        Alpine.start();

        // Responsive behavior
        function resizeCharts() {
            salesChart.resize();
            categoryChart.resize();
        }

        window.addEventListener('resize', resizeCharts);
    });
</script>
@endpush
@endsection
