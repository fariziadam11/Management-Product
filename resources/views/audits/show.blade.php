@extends('layouts.app')

@section('page_heading', 'Audit Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Audit #{{ $audit->id }} - {{ class_basename($audit->auditable_type) }}
                        <span class="badge {{ $audit->event == 'created' ? 'bg-success' : ($audit->event == 'updated' ? 'bg-info' : ($audit->event == 'deleted' ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ ucfirst($audit->event) }}
                        </span>
                    </h6>
                    <div>
                        <a href="{{ route('audits.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back to Audit Logs
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">User</h6>
                                @if($audit->user)
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ urlencode($audit->user->name) }}&background=4e73df&color=ffffff&size=32" alt="{{ $audit->user->name }}" width="32" height="32">
                                        <div>
                                            <div>{{ $audit->user->name }}</div>
                                            <div class="small text-muted">{{ $audit->user->email }}</div>
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
                        <h6 class="fw-bold mb-3">Modified Data</h6>
                        @if($audit->event == 'created')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 30%;">Field</th>
                                            <th>Value</th>
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
                                            <th style="width: 20%;">Field</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
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
                                                        <span class="text-muted">N/A</span>
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
                        <h6 class="fw-bold mb-3">Related Audits</h6>
                        <div class="table-responsive">
                            @php
                                $relatedAudits = \App\Models\Audit::where('auditable_type', $audit->auditable_type)
                                    ->where('auditable_id', $audit->auditable_id)
                                    ->where('id', '!=', $audit->id)
                                    ->orderBy('created_at', 'desc')
                                    ->take(10)
                                    ->get();
                            @endphp
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Event</th>
                                        <th>Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($relatedAudits as $relatedAudit)
                                        <tr class="{{ $relatedAudit->id == $audit->id ? 'table-primary' : '' }}">
                                            <td>
                                                @if($relatedAudit->user)
                                                    <div class="d-flex align-items-center">
                                                        <img class="rounded-circle me-2" src="https://ui-avatars.com/api/?name={{ urlencode($relatedAudit->user->name) }}&background=4e73df&color=ffffff&size=24" alt="{{ $relatedAudit->user->name }}" width="24" height="24">
                                                        {{ $relatedAudit->user->name }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">System</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($relatedAudit->event == 'created')
                                                    <span class="badge bg-success">Created</span>
                                                @elseif($relatedAudit->event == 'updated')
                                                    <span class="badge bg-info">Updated</span>
                                                @elseif($relatedAudit->event == 'deleted')
                                                    <span class="badge bg-danger">Deleted</span>
                                                @elseif($relatedAudit->event == 'restored')
                                                    <span class="badge bg-warning">Restored</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $relatedAudit->event }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $relatedAudit->created_at->format('M d, Y H:i:s') }}</td>
                                            <td>
                                                @if($relatedAudit->id != $audit->id)
                                                    <a href="{{ route('audits.show', $relatedAudit->id) }}" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                @else
                                                    <span class="badge bg-primary">Current</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No related audit logs found.</td>
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
