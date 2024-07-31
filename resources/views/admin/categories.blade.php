@extends('templates.template')
@section('content')
    <div class="container-xl mt-3">

        <div class="admin-header d-flex align-items-center mb-3">
            <div class="header-title p-2 flex-grow-1">
                <h1>Categories</h1>
                <p>All the item's category are here.</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2" href="#">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
                <a class="btn btn-primary px-4 py-2" href="#">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            @foreach ($categories as $category)
                <div class="card mb-3">
                    <div class="card-body categories-card-body">
                        <h3 class="card-title categories-card title ms-2">{{ $category->category_name }}</h3>
                        <p class="card-text categories-card-text ms-2">{{ $category->category_description }}</p>
                        <a class="card-link" href="#">Card link</a>
                        <a class="card-link" href="#">Another link</a>
                    </div>
                </div>
            @endforeach
        </div>



    </div>
@endsection
