@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Subscriptions</h1>
                <p>See all of our subscribers. ({{ $subCount }})</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2 me-2" href="#">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            <div class="input-group mb-3">
                <input class="form-control fs-3" type="search" aria-label="Search" aria-describedby="searchbutton"
                    placeholder="Search...">
                <button class="btn btn-outline-primary fs-3 px-5" id="searchbutton" type="button">Search</button>
                <button class="btn btn-outline-secondary fs-3 px-5" id="clearbutton" type="button">Clear</button>
            </div>

            <div class="table-responsive-lg fs-4">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 15%" scope="col">Subscription #</th>
                            <th style="width: 60%" scope="col">Email</th>
                            <th style="width: 20%" scope="col">Subscribed at:</th>
                            <th style="width: 5%" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->id }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->subscribed_at }}</td>
                                <td>
                                    <a class="btn btn-danger deleteitem-btn" data-bs-toggle="modal"
                                        data-bs-target="#subscriberDeleteModal" data-id="{{ $subscriber->id }}">
                                        <i class="bi bi-bell-slash-fill"></i></a>
                                </td>
                            </tr>
                        @empty
                            <div>
                                <h4 style="color: red">No subscribers!</h4>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
