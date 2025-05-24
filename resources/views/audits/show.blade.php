@extends('layouts.app')

@section('page_heading', 'Audit Details')

@section('content')
<div class="container-fluid px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    <div class="row">
        <div class="w-full lg:w-10/12 mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 sm:mb-6">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <h6 class="text-base sm:text-lg font-semibold text-blue-600">
                        Audit #{{ $audit->id }} - {{ class_basename($audit->auditable_type) }}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $audit->event == 'created' ? 'bg-green-100 text-green-800' : ($audit->event == 'updated' ? 'bg-blue-100 text-blue-800' : ($audit->event == 'deleted' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($audit->event) }}
                        </span>
                    </h6>
                    <div>
                        <a href="{{ route('audits.index') }}" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 border border-blue-600 text-blue-600 bg-white hover:bg-blue-50 rounded-md text-sm transition-colors duration-150 ease-in-out">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg> Back to Audit Logs
                        </a>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">User</h6>
                                @if($audit->user)
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($audit->user->name) }}&background=4e73df&color=ffffff&size=32" alt="{{ $audit->user->name }}" width="32" height="32">
                                        <div>
                                            <div>{{ $audit->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $audit->user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Date & Time</h6>
                                <p>{{ $audit->created_at->format('F d, Y \a\t h:i:s A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Model Type</h6>
                                <p>{{ class_basename($audit->auditable_type) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Model ID</h6>
                                <p>{{ $audit->auditable_id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">IP Address</h6>
                                <p>{{ $audit->ip_address ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">User Agent</h6>
                                <p class="text-truncate" title="{{ $audit->user_agent ?? 'N/A' }}">{{ $audit->user_agent ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-base font-medium text-gray-800 mb-3">Modified Data</h6>
                        @if($audit->event == 'created')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 30%;">Field</th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audit->new_values as $key => $value)
                                            <tr>
                                                <td class="fw-bold">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                                <td>
                                                    @if(is_array($value) || is_object($value))
                                                        <pre class="bg-light p-3 rounded"><code>{{ json_encode($value, JSON_PRETTY_PRINT) }}</code></pre>
                                                    @elseif(is_bool($value))
                                                        <span class="badge {{ $value ? 'bg-success' : 'bg-danger' }}">{{ $value ? 'True' : 'False' }}</span>
                                                    @elseif($value === null)
                                                        <span class="text-muted">NULL</span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($audit->event == 'updated')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Field</th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Old Value</th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audit->new_values as $key => $value)
                                            <tr>
                                                <td class="fw-bold">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                                <td>
                                                    @if(isset($audit->old_values[$key]))
                                                        @if(is_array($audit->old_values[$key]) || is_object($audit->old_values[$key]))
                                                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($audit->old_values[$key], JSON_PRETTY_PRINT) }}</code></pre>
                                                        @elseif(is_bool($audit->old_values[$key]))
                                                            <span class="badge {{ $audit->old_values[$key] ? 'bg-success' : 'bg-danger' }}">{{ $audit->old_values[$key] ? 'True' : 'False' }}</span>
                                                        @elseif($audit->old_values[$key] === null)
                                                            <span class="text-muted">NULL</span>
                                                        @else
                                                            {{ $audit->old_values[$key] }}
                                                        @endif
                                                    @else
                                                        <span class="text-xs sm:text-sm text-gray-400">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(is_array($value) || is_object($value))
                                                        <pre class="bg-light p-3 rounded"><code>{{ json_encode($value, JSON_PRETTY_PRINT) }}</code></pre>
                                                    @elseif(is_bool($value))
                                                        <span class="badge {{ $value ? 'bg-success' : 'bg-danger' }}">{{ $value ? 'True' : 'False' }}</span>
                                                    @elseif($value === null)
                                                        <span class="text-muted">NULL</span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif($audit->event == 'deleted')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 30%;">Field</th>
                                            <th>Value at Deletion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audit->old_values as $key => $value)
                                            <tr>
                                                <td class="fw-bold">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                                <td>
                                                    @if(is_array($value) || is_object($value))
                                                        <pre class="bg-light p-3 rounded"><code>{{ json_encode($value, JSON_PRETTY_PRINT) }}</code></pre>
                                                    @elseif(is_bool($value))
                                                        <span class="badge {{ $value ? 'bg-success' : 'bg-danger' }}">{{ $value ? 'True' : 'False' }}</span>
                                                    @elseif($value === null)
                                                        <span class="text-muted">NULL</span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                No detailed information available for this audit event.
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Related Model</h6>
                        @if($audit->auditable)
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>
                                The related {{ class_basename($audit->auditable_type) }} (ID: {{ $audit->auditable_id }}) still exists in the database.

                                @php
                                    $modelType = strtolower(class_basename($audit->auditable_type));
                                    $routeName = $modelType . 's.show';
                                @endphp

                                @if(Route::has($routeName))
                                    <a href="{{ route($routeName, $audit->auditable_id) }}" class="alert-link">
                                        View {{ class_basename($audit->auditable_type) }}
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                The related {{ class_basename($audit->auditable_type) }} (ID: {{ $audit->auditable_id }}) no longer exists in the database.
                            </div>
                        @endif
                    </div>

                    <div>
                        <h6 class="text-base font-medium text-gray-800 mb-3 md:text-lg">Related Audit Logs</h6>
                        <div class="table-responsive">
                            @php
                                $relatedAudits = \App\Models\Audit::where('auditable_type', $audit->auditable_type)
                                    ->where('auditable_id', $audit->auditable_id)
                                    ->where('id', '!=', $audit->id)
                                    ->orderBy('created_at', 'desc')
                                    ->take(10)
                                    ->get();
                            @endphp
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($relatedAudits as $relatedAudit)
                                        <tr class="{{ $relatedAudit->id == $audit->id ? 'bg-blue-50' : '' }} hover:bg-gray-50">
                                            <td>
                                                @if($relatedAudit->user)
                                                    <div class="flex items-center">
                                                        <img class="rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($relatedAudit->user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $relatedAudit->user->name }}" width="24" height="24">
                                                        {{ $relatedAudit->user->name }}
                                                    </div>
                                                @else
                                                    <span class="text-xs sm:text-sm text-gray-500">System</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($relatedAudit->event == 'created')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Created</span>
                                                @elseif($relatedAudit->event == 'updated')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Updated</span>
                                                @elseif($relatedAudit->event == 'deleted')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Deleted</span>
                                                @elseif($relatedAudit->event == 'restored')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Restored</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $relatedAudit->event }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $relatedAudit->created_at->format('M d, Y H:i:s') }}</td>
                                            <td>
                                                @if($relatedAudit->id != $audit->id)
                                                    <a href="{{ route('audits.show', $relatedAudit->id) }}" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700">
                                                        <svg class="-ml-0.5 mr-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> View
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Current</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-3 sm:px-6 py-4 text-center text-xs sm:text-sm text-gray-500">No related audit logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Responsive styles */
    @media (max-width: 640px) {
        .overflow-x-auto {
            margin-left: -1rem;
            margin-right: -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    pre {
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    code {
        color: #333;
    }

    .table-primary {
        --bs-table-bg: rgba(78, 115, 223, 0.1);
    }
</style>
@endsection
