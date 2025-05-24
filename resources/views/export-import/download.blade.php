@extends('layouts.app')

@section('page_heading', 'Download Export')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Export Ready for Download</h6>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="feature-icon bg-success bg-gradient text-white mx-auto mb-4" style="width: 5rem; height: 5rem; font-size: 2.5rem;">
                            <i class="bi bi-file-earmark-check"></i>
                        </div>
                        <h4>Your export is ready!</h4>
                        <p class="text-muted">
                            Your export of {{ $export->record_count }} {{ Str::plural(Str::lower($export->type), $export->record_count) }} has been successfully generated.
                        </p>
                    </div>

                    <div class="card mb-4 mx-auto" style="max-width: 500px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($export->format == 'csv')
                                        <i class="bi bi-filetype-csv text-success" style="font-size: 2rem;"></i>
                                    @elseif($export->format == 'xlsx')
                                        <i class="bi bi-file-earmark-excel text-primary" style="font-size: 2rem;"></i>
                                    @elseif($export->format == 'json')
                                        <i class="bi bi-filetype-json text-warning" style="font-size: 2rem;"></i>
                                    @else
                                        <i class="bi bi-file-earmark text-secondary" style="font-size: 2rem;"></i>
                                    @endif
                                </div>
                                <div class="text-start">
                                    <h5 class="mb-0">{{ $export->filename }}</h5>
                                    <p class="text-muted mb-0">
                                        {{ number_format($export->file_size / 1024, 2) }} KB |
                                        {{ strtoupper($export->format) }} |
                                        {{ $export->record_count }} records
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('export.download', $export->filename) }}" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-download me-2"></i> Download Now
                            </a>
                        </div>
                    </div>

                    <div class="alert alert-info d-inline-block">
                        <i class="bi bi-info-circle me-2"></i>
                        This download link will be available for the next 24 hours.
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('export.form', $export->type) }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Export
                        </a>
                        <a href="{{ route($export->type . '.index') }}" class="btn btn-outline-secondary">
                            Return to {{ ucfirst($export->type) }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Export Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Export Type</label>
                                <p>{{ ucfirst($export->type) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Format</label>
                                <p>
                                    <span class="badge {{ $export->format == 'csv' ? 'bg-success' : ($export->format == 'xlsx' ? 'bg-primary' : 'bg-warning') }}">
                                        {{ strtoupper($export->format) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Records Exported</label>
                                <p>{{ number_format($export->record_count) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">File Size</label>
                                <p>{{ number_format($export->file_size / 1024, 2) }} KB</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Created</label>
                                <p>{{ $export->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Expires</label>
                                <p>{{ $export->created_at->addDay()->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    @if(!empty($export->filters))
                        <div class="mt-3">
                            <h6 class="fw-bold">Applied Filters</h6>
                            <ul class="list-group">
                                @foreach($export->filters as $key => $value)
                                    @if(!empty($value))
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                            <span class="badge bg-primary rounded-pill">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .feature-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
    }
</style>
@endsection
