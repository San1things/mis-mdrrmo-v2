@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">

        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h3>Categories</h3>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-3 addcategory-btn" data-bs-toggle="modal"
                    data-bs-target="#categoryAddUpdateModal" href="#">
                    <i class="bi bi-card-list"></i>
                    <span>Create Category</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            @foreach ($categories as $category)
                <div class="card mb-3 position-relative">
                    <div class="position-absolute top-0 end-0 pe-3 pt-2">
                        <a class="updatecategory-btn" data-bs-toggle="modal" data-bs-target="#categoryAddUpdateModal" type="button" href="#"
                            data-id="{{ $category->id }}"
                            data-category-name="{{ $category->category_name }}" data-category-description="{{ $category->category_description }}"><i
                                class="bi bi-pencil-square me-3 jl-card-edit-btn"></i></a>
                        <a class="deletecategory-btn" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal" data-id="{{ $category->id }}"
                            type="button" href="#"><i class="bi bi-x-lg jl-card-x-btn"></i></a>
                    </div>
                    <div class="card-body categories-card-body">
                        <h6 class="card-title categories-card title ms-2">{{ $category->category_name }}</h6>
                        <p class="card-text categories-card-text ms-2 fs-4">{{ $category->category_description }}</p>
                        <a class="card-link categories-card-link fs-4"
                            href="/inventory?category={{ $category->category_name }}">See {{ $category->item_count }} items
                            in this
                            category...</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="modal fade" id="categoryAddUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle"></h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form id="modalForm" action="" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fs-3" for="form-label fs-4">Category Name:</label>
                                <input class="form-control fs-3" id="categoryname" name="categoryname" type="text"
                                    placeholder="Category Name">
                            </div>
                            <div class="mb-3">
                                <label class="fomr-label fs-3" for="floatingInput">Category Description:</label>
                                <textarea class="form-control fs-3" id="categorydescription" name="categorydescription" placeholder="Category Description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary fs-3 px-5 btn-save" type="submit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="categoryDeleteModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form id="modalForm" action="" method="post">
                        @csrf
                        <div class="modal-body ms-2">
                            <h6 class="fs-2">Are you sure you want to delete this category?</h6>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger fs-3 py-2 px-5 btn-delete" type="submit">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.addcategory-btn').on('click', function() {
                $('.btn-save').text('Add Category')
                $('#categoryname').val('')
                $('#categorydescription').val('')
                $('#modalForm').attr('action', '/createcategory')
            })

            $('.updatecategory-btn').on('click', function() {
                let id = $(this).data('id')
                $('.btn-save').text('Update Category')
                $('#modalTitle').text('UPDATE CATEGORY')
                $('#categoryname').val($(this).data('category-name'))
                $('#categorydescription').val($(this).data('category-description'))
                $('#modalForm').attr('action', '/updatecategory?id=' + id)
            })

            $('.deletecategory-btn').on('click', function() {
                let id = $(this).data('id')
                $('#modalForm').attr('action', '/deletecategory?id=' + id)
            })
        })
    </script>
@endpush
