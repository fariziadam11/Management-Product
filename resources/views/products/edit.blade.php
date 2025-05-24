@extends('layouts.app')

@section('page_heading', 'Edit Product')

@section('page_actions')
<a href="{{ route('products.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Back to Products
</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                            <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <div class="image-upload-container mb-3">
                                        <div class="image-preview" id="imagePreview">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                            @else
                                                <img src="{{ asset('images/placeholder.png') }}" alt="Image Preview" class="img-fluid rounded">
                                            @endif
                                            <div class="image-upload-placeholder" style="{{ $product->image ? 'display: none;' : '' }}">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                                <p>Click or drag to upload</p>
                                            </div>
                                        </div>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended size: 800x800px. Max file size: 2MB.</small>

                                    @if($product->image)
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                            <label class="form-check-label" for="remove_image">
                                                Remove current image
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <!-- PDF Upload -->
                                <div class="mb-3">
                                    <label for="pdf_path" class="form-label">Product Documentation (PDF)</label>
                                    <input type="file" class="form-control @error('pdf_path') is-invalid @enderror" id="pdf_path" name="pdf_path" accept=".pdf">
                                    @error('pdf_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($product->pdf_path)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $product->pdf_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-file-earmark-pdf"></i> View Current PDF
                                            </a>

                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_pdf" name="remove_pdf" value="1">
                                                <label class="form-check-label" for="remove_pdf">
                                                    Remove current PDF
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="statusActive" value="1" {{ old('is_active', $product->is_active) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="statusInactive" value="0" {{ old('is_active', $product->is_active) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                    </div>
                                </div>

                                <!-- Featured -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Product
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="font-weight-bold">Product Specifications</h6>
                                <div id="specifications-container">
                                    @php
                                        $details = json_decode($product->details, true) ?? [];
                                    @endphp

                                    @if(count($details) > 0)
                                        @foreach($details as $key => $value)
                                            <div class="specification-row row mb-2">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="spec_keys[]" value="{{ $key }}" placeholder="Specification (e.g. Weight)">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="spec_values[]" value="{{ $value }}" placeholder="Value (e.g. 2.5 kg)">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-sm btn-danger remove-specification">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="specification-row row mb-2">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="spec_keys[]" placeholder="Specification (e.g. Weight)">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="spec_values[]" placeholder="Value (e.g. 2.5 kg)">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-specification">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-specification">
                                    <i class="bi bi-plus-circle"></i> Add Specification
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .image-upload-container {
        position: relative;
    }

    .image-preview {
        width: 100%;
        height: 200px;
        border: 2px dashed #ddd;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .image-upload-placeholder {
        text-align: center;
        color: #aaa;
        z-index: 1;
    }

    .image-upload-placeholder i {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .image-preview:hover .image-upload-placeholder {
        color: #4e73df;
    }

    #image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview').querySelector('img');
        const placeholder = document.querySelector('.image-upload-placeholder');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    placeholder.style.display = 'none';
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        // Add specification row
        document.getElementById('add-specification').addEventListener('click', function() {
            const container = document.getElementById('specifications-container');
            const newRow = document.createElement('div');
            newRow.className = 'specification-row row mb-2';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control" name="spec_keys[]" placeholder="Specification (e.g. Weight)">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="spec_values[]" placeholder="Value (e.g. 2.5 kg)">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger remove-specification">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);

            // Add event listener to the new remove button
            newRow.querySelector('.remove-specification').addEventListener('click', function() {
                container.removeChild(newRow);
            });
        });

        // Remove specification row
        document.querySelectorAll('.remove-specification').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('.specification-row');
                row.parentNode.removeChild(row);
            });
        });

        // Handle remove image checkbox
        const removeImageCheckbox = document.getElementById('remove_image');
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('image').disabled = true;
                } else {
                    document.getElementById('image').disabled = false;
                }
            });
        }

        // Handle remove PDF checkbox
        const removePdfCheckbox = document.getElementById('remove_pdf');
        if (removePdfCheckbox) {
            removePdfCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('pdf_path').disabled = true;
                } else {
                    document.getElementById('pdf_path').disabled = false;
                }
            });
        }
    });
</script>
@endsection
