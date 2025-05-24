@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">Laravel Management System</h1>
                    <p class="lead">A comprehensive solution for managing roles, users, categories, products, and reviews with advanced auditing and Excel import/export capabilities.</p>
                    @guest
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Register</a>
                        </div>
                    @else
                        <div class="mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
                        </div>
                    @endguest
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="https://cdn.pixabay.com/photo/2018/05/08/08/44/artificial-intelligence-3382507_960_720.jpg" alt="Dashboard Illustration" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mb-5">
        <h2 class="text-center mb-4">Key Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="card-title h5">User & Role Management</h3>
                        <p class="card-text">Comprehensive user management with role-based access control to secure your application.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h3 class="card-title h5">Product & Category Management</h3>
                        <p class="card-text">Efficiently manage your products and categories with advanced filtering and search capabilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>
                        <h3 class="card-title h5">Excel Import/Export</h3>
                        <p class="card-text">Seamlessly import and export data with background processing for optimal performance.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 class="card-title h5">Advanced Search & Filtering</h3>
                        <p class="card-text">Powerful search and filtering capabilities across all entities for quick data retrieval.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h3 class="card-title h5">Comprehensive Auditing</h3>
                        <p class="card-text">Track all changes with detailed audit trails to maintain data integrity and accountability.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-star"></i>
                        </div>
                        <h3 class="card-title h5">Product Reviews</h3>
                        <p class="card-text">Collect and manage product reviews to improve customer satisfaction and product quality.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-light py-5">
        <div class="container text-center">
            <h2>Ready to Get Started?</h2>
            <p class="lead mb-4">Join our platform today and experience the power of our comprehensive management system.</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Sign Up Now</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
            @endguest
        </div>
    </div>
</div>

<style>
.feature-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    font-size: 1.5rem;
}
</style>
@endsection
