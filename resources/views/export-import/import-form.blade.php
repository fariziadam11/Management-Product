@extends('layouts.app')

@section('page_heading', 'Import Data')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Import {{ ucfirst($type) }}</h6>
                    <div>
                        <a href="{{ route($type . '.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back to {{ ucfirst($type) }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('import.process', ['type' => $type]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <!-- Upload File -->
                        <div class="mb-4">
                            <label for="import_file" class="form-label fw-bold">Upload File</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('import_file') is-invalid @enderror" id="import_file" name="import_file" required>
                                <span class="input-group-text"><i class="bi bi-upload"></i></span>
                            </div>
                            <div class="form-text">Supported formats: CSV, Excel (XLSX)</div>
                            @error('import_file')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Import Options -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Import Options</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="options[header_row]" id="option_header" value="1" checked>
                                                <label class="form-check-label" for="option_header">
                                                    File contains header row
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="options[update_existing]" id="option_update" value="1">
                                                <label class="form-check-label" for="option_update">
                                                    Update existing records
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="options[skip_validation]" id="option_skip" value="1">
                                                <label class="form-check-label" for="option_skip">
                                                    Skip validation (not recommended)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="options[dry_run]" id="option_dry" value="1">
                                                <label class="form-check-label" for="option_dry">
                                                    Dry run (validate without importing)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column Mapping -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Column Mapping</label>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> Column mapping will be automatically detected based on the file headers. You can adjust the mapping after uploading.
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">File Column</th>
                                            <th style="width: 40%;">Database Field</th>
                                            <th style="width: 20%;">Required</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($type == 'users')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[name]" value="name" placeholder="Column name in file"></td>
                                                <td>Name</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[email]" value="email" placeholder="Column name in file"></td>
                                                <td>Email</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[role_id]" value="role_id" placeholder="Column name in file"></td>
                                                <td>Role</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[is_active]" value="is_active" placeholder="Column name in file"></td>
                                                <td>Active Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @elseif($type == 'products')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[name]" value="name" placeholder="Column name in file"></td>
                                                <td>Name</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[category_id]" value="category_id" placeholder="Column name in file"></td>
                                                <td>Category</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[price]" value="price" placeholder="Column name in file"></td>
                                                <td>Price</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[stock]" value="stock" placeholder="Column name in file"></td>
                                                <td>Stock</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[description]" value="description" placeholder="Column name in file"></td>
                                                <td>Description</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[is_featured]" value="is_featured" placeholder="Column name in file"></td>
                                                <td>Featured Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @elseif($type == 'categories')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[name]" value="name" placeholder="Column name in file"></td>
                                                <td>Name</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[description]" value="description" placeholder="Column name in file"></td>
                                                <td>Description</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[uuid]" value="uuid" placeholder="Column name in file"></td>
                                                <td>UUID</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[is_active]" value="is_active" placeholder="Column name in file"></td>
                                                <td>Active Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @elseif($type == 'reviews')
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[product_id]" value="product_id" placeholder="Column name in file"></td>
                                                <td>Product</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[user_id]" value="user_id" placeholder="Column name in file"></td>
                                                <td>User</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[rating]" value="rating" placeholder="Column name in file"></td>
                                                <td>Rating</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[title]" value="title" placeholder="Column name in file"></td>
                                                <td>Title</td>
                                                <td><span class="badge bg-danger">Required</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[content]" value="content" placeholder="Column name in file"></td>
                                                <td>Content</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[reviewer_name]" value="reviewer_name" placeholder="Column name in file"></td>
                                                <td>Reviewer Name</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[reviewer_email]" value="reviewer_email" placeholder="Column name in file"></td>
                                                <td>Reviewer Email</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" name="mapping[status]" value="status" placeholder="Column name in file"></td>
                                                <td>Status</td>
                                                <td><span class="badge bg-secondary">Optional</span></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route($type . '.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i> Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Import History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Import History</h6>
                </div>
                <div class="card-body">
                    @if(count($previousImports) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>File</th>
                                        <th>Records</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($previousImports as $import)
                                        <tr>
                                            <td>{{ $import->created_at->format('M d, Y H:i') }}</td>
                                            <td>{{ ucfirst($import->type) }}</td>
                                            <td>{{ $import->filename }}</td>
                                            <td>
                                                <div>Processed: {{ number_format($import->processed_count) }}</div>
                                                <div class="small text-success">Success: {{ number_format($import->success_count) }}</div>
                                                <div class="small text-danger">Failed: {{ number_format($import->error_count) }}</div>
                                            </td>
                                            <td>
                                                @if($import->status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($import->status == 'processing')
                                                    <span class="badge bg-warning">Processing</span>
                                                @elseif($import->status == 'failed')
                                                    <span class="badge bg-danger">Failed</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($import->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($import->error_log)
                                                    <a href="{{ route('import.download-log', $import->id) }}" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-download"></i> Error Log
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> No import history found.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sample Template -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Download Sample Template</h6>
                </div>
                <div class="card-body">
                    <p>Download a sample template to see the expected format for importing {{ $type }}:</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('import.sample-template', ['type' => $type, 'format' => 'csv']) }}" class="btn btn-outline-success">
                            <i class="bi bi-filetype-csv me-1"></i> CSV Template
                        </a>
                        <a href="{{ route('import.sample-template', ['type' => $type, 'format' => 'xlsx']) }}" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark-excel me-1"></i> Excel Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
