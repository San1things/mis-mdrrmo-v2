@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">

        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark" style="position: relative">
            <div class="header-title p-2 flex-grow-1">
                <h1>Inventory</h1>
                <p>All the items information is here.</p>
            </div>
            <div class="header-export">
                <a class="btn btn-primary px-4 py-2" href="#">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
                <a class="btn btn-primary px-4 py-2 additem-btn" data-bs-toggle="modal"
                    data-bs-target="#inventoryAddUpdateModal" href="#">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add</span>
                </a>
            </div>
            <a href="/categories" style="position: absolute; bottom: 0; right: 0; font-size:1.5rem;">Add Categories..</a>
        </div>

        <div class="admin-content">

            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fade show fs-3 alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : 'error' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset

            <h3>All items({{ $itemsCount }})</h3>
            <nav class="navbar navbar-expand-lg bg-body-light p-3">
                <div class="container-xl">
                    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item border">
                                <a class="nav-link" href="?category=&searchItem={{ $qstring['searchItem'] }}"
                                    aria-current="page"
                                    style="{{ request('category') === null ? 'font-weight: 700;' : '' }}">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link"
                                    href="?category=Personal+Protective+Equipment&searchItem={{ $qstring['searchItem'] }}"
                                    style="{{ request('category') === 'Personal Protective Equipment' ? 'font-weight: 700;' : '' }}">PPE</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link"
                                    href="?category=Disaster+Supplies&searchItem={{ $qstring['searchItem'] }}"
                                    style="{{ request('category') === 'Disaster Supplies' ? 'font-weight: 700;' : '' }}">Disaster
                                    Supplies</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?category=Vehicles&searchItem={{ $qstring['searchItem'] }}"
                                    style="{{ request('category') === 'Vehicles' ? 'font-weight: 700;' : '' }}">Vehicles</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?category=Medicines&searchItem={{ $qstring['searchItem'] }}"
                                    style="{{ request('category') === 'Medicines' ? 'font-weight: 700;' : '' }}">Medicines</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?category=other&searchItem={{ $qstring['searchItem'] }}"
                                    style="{{ request('category') === 'other' ? 'font-weight: 700;' : '' }}">Other</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="category" type="hidden" value="{{ $qstring['category'] }}">
                            <input class="form-control me-3 fs-4" name="searchItem" type="search" value=""
                                aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-primary me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="?category=&searchItem=">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="table-responsive-lg fs-4" style="min-height: 60vh; max-height: 60vh; overflow-y:scroll;">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead style="position: sticky; top: 0;">
                        <tr>
                            <th style="width: 10%" scope="col">#</th>
                            <th style="width: 15%" scope="col-4">Item Name</th>
                            <th style="width: 35%" scope="col-4">Item Description</th>
                            <th scope="col-4"style="width: 20%">Category</th>
                            <th scope="col-1"style="width: 10%">Quantity</th>
                            <th scope="col-1"style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_description }}</td>
                                <td>{{ $item->item_category }}</td>
                                <td>{{ $item->item_quantity }}</td>
                                <td>
                                    <a class="btn btn-primary updateitem-btn" data-bs-toggle="modal"
                                        data-bs-target="#inventoryAddUpdateModal" data-id="{{ $item->id }}"
                                        data-itemname="{{ $item->item_name }}"
                                        data-itemdescription="{{ $item->item_description }}"
                                        data-category_id="{{ $item->category_id }}"
                                        data-itemquantity="{{ $item->item_quantity }}"
                                        data-itemexpired="{{ $item->expired_at }}" href="#">
                                        <i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-danger deleteitem-btn" data-bs-toggle="modal"
                                        data-bs-target="#inventoryDeleteModal" data-id="{{ $item->id }}"><i
                                            class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div>
                                <h4 style="color: red">NO ITEMS FOUND!</h4>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="inventoryAddUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
                            <label class="form-label fs-3" for="form-label fs-4">Item Name:</label>
                            <input class="form-control fs-3" id="itemname" name="itemname" type="text"
                                placeholder="Item Name">
                        </div>
                        <div class="mb-3">
                            <label class="fomr-label fs-3" for="floatingInput">Item Description</label>
                            <input class="form-control fs-3" id="itemdescription" name="itemdescription"
                                placeholder="Item Description"></input>
                        </div>
                        <div class="mb-3">
                            <select class="form-select fs-3" id="itemcategory" name="itemcategory">
                                <option value="" hidden>Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <span class="fs-4" id="itemexpiredlabel" style="display: none">Expiration Date:</span>
                            <input class="form-control fs-3" id="itemexpired" name="itemexpired" type="hidden"></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-3" for="floatingInput">Quantity</label>
                            <input class="form-control fs-3" id="itemquantity" name="itemquantity" type="number"
                                placeholder="Quantity"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary fs-3 px-5 btn-save" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inventoryDeleteModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="" method="post">
                    @csrf
                    <div class="modal-body ms-2">
                        <h2>Are you sure you want to delete this item?</h2>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger fs-3 btn-delete" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                $('.additem-btn').on('click', function() {
                    $('.btn-save').text('ADD')
                    $('#modalTitle').text('ADD ITEM')
                    $('#modalForm').attr('action', '/additem')
                })

                $('.updateitem-btn').on('click', function() {
                    let id = $(this).data('id');
                    $('#itemname').val($(this).data('itemname'))
                    $('#itemdescription').val($(this).data('itemdescription'))
                    $('#itemcategory').val($(this).data('category_id'))
                    if ($('#itemcategory option:selected').text() === "Medicines") {
                        $('#itemexpired').attr('type', 'date')
                        $('#itemexpiredlabel').attr('style', '')
                    } else {
                        $('#itemexpired').attr('type', 'hidden')
                        $('#itemexpiredlabel').attr('style', 'display: none')
                    }
                    $('#itemexpired').val($(this).data('itemexpired'))
                    $('#itemquantity').val($(this).data('itemquantity'))
                    $('.btn-save').text('UPDATE')
                    $('#modalTitle').text('UPDATE ITEM')
                    $('#modalForm').attr('action', '/updateitem')

                })

                $('#itemcategory').on('click', function() {
                    let categoryname = $('#itemcategory option:selected').text()
                    if (categoryname === "Medicines") {
                        $('#itemexpired').attr('type', 'date')
                        $('#itemexpiredlabel').attr('style', '')
                    } else {
                        $('#itemexpired').attr('type', 'hidden')
                        $('#itemexpiredlabel').attr('style', 'display: none')
                    }
                })

                $('.deleteitem-btn').on('click', function() {
                    let id = $(this).data('id');
                    $('#modalForm').attr('action', '/deleteitem?id=' + id)
                })
            })
        </script>
    @endpush
@endsection
