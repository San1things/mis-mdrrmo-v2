@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">

        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h3>Categories</h3>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-3" href="#">
                    <i class="bi bi-card-list"></i>
                    <span>Create Category</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            @foreach ($categories as $category)
                <div class="card mb-3 position-relative">
                    <div class="position-absolute top-0 end-0 pe-3 pt-2">
                        <a href="#"><i class="bi bi-pencil-square me-3 jl-card-edit-btn"></i></a>
                        <a href="#"><i class="bi bi-x-lg jl-card-x-btn"></i></a>
                    </div>
                    <div class="card-body categories-card-body">
                        <h3 class="card-title categories-card title ms-2">{{ $category->category_name }}</h3>
                        <p class="card-text categories-card-text ms-2">{{ $category->category_description }}</p>
                        <a class="card-link categories-card-link" href="/inventory?category={{ $category->category_name }}">See {{ $category->item_count }} items in this
                            category...</a>
                    </div>
                </div>
            @endforeach
        </div>



    </div>
@endsection
