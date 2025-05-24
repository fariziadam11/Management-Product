@extends('layouts.app')

@section('page_heading', 'Import Errors')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Import Errors for {{ $import->filename }}</h6>
                    <div>
                        <a href="{{ route('import.form', $import->type) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Back to Import
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Import Completed with Errors</h5>
                                <p class="mb-0">
                                    Your import of <strong>{{ $import->filename }}</strong> completed with {{ $import->error_count }} errors.
                                    {{ $import->processed_rows }} out of {{ $import->total_rows }} rows were processed successfully.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">Row #</th>
                                    <th>Error Message</th>
                                    <th>Column</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($errors as $error)
                                    <tr>
                                        <td class="text-center">{{ $error->row_number }}</td>
                                        <td>{{ $error->message }}</td>
                                        <td>{{ $error->column_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($error->value)
                                                <code>{{ Str::limit($error->value, 50) }}</code>
                                            @else
                                                <span class="text-muted">Empty</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $errors->links() }}
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">How to Fix Common Import Errors</h6>
                </div>
                <div class="card-body">
                    <div class="accordion" id="errorHelpAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Required Field Missing
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#errorHelpAccordion">
                                <div class="accordion-body">
                                    <p>This error occurs when a required field is missing from your import file.</p>
                                    <p><strong>How to fix:</strong></p>
                                    <ul>
                                        <li>Make sure all required fields have values in your import file</li>
                                        <li>Check that column names match exactly (they are case-sensitive)</li>
                                        <li>If using CSV, ensure your delimiter is correct (comma by default)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Invalid Format
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#errorHelpAccordion">
                                <div class="accordion-body">
                                    <p>This error occurs when a field value doesn't match the expected format.</p>
                                    <p><strong>How to fix:</strong></p>
                                    <ul>
                                        <li>Dates should be in YYYY-MM-DD format</li>
                                        <li>Numbers should not contain currency symbols or commas</li>
                                        <li>Boolean values should be 1/0, true/false, or yes/no</li>
                                        <li>Email addresses must be valid</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Invalid Reference
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#errorHelpAccordion">
                                <div class="accordion-body">
                                    <p>This error occurs when a reference to another record (like category_id) doesn't exist in the database.</p>
                                    <p><strong>How to fix:</strong></p>
                                    <ul>
                                        <li>Make sure the referenced ID exists in the database</li>
                                        <li>If using names instead of IDs, ensure they match exactly</li>
                                        <li>Import related records first (e.g., import categories before products)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Duplicate Record
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#errorHelpAccordion">
                                <div class="accordion-body">
                                    <p>This error occurs when a unique constraint is violated (e.g., duplicate email address).</p>
                                    <p><strong>How to fix:</strong></p>
                                    <ul>
                                        <li>Check for duplicate values in unique fields</li>
                                        <li>If updating existing records, include the ID field</li>
                                        <li>Use "Update Only" or "Insert & Update" mode instead of "Insert Only"</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <a href="{{ route('import.form', $import->type) }}" class="btn btn-primary">
                    <i class="bi bi-arrow-repeat me-1"></i> Try Another Import
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        color: #e83e8c;
    }
</style>
@endsection
