@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark position-relative">
            <div class="header-title p-2 flex-grow-1">
                <h1>Subscriptions</h1>
                <p>See all of our subscribers. ({{ $subCount }})</p>
            </div>
            <div class="header-export pe-3">
                <a class="btn btn-primary px-4 py-2 me-2" href="{{ route('generate-subscription-pdf', request()->query()) }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>

                <div class="btn-group position-absolute bottom-0 end-0 pe-4 pb-2">
                    <button class="btn btn-lite dropdown-toggle fs-3" data-bs-toggle="dropdown" type="button"
                        aria-expanded="false">
                        @if ($qstring['last'] == 'week')
                            Last Week
                        @elseif ($qstring['last'] == 'month')
                            Last Month
                        @elseif ($qstring['last'] == '6months')
                            Last 6 Months
                        @elseif ($qstring['last'] == 'year')
                            Last Year
                        @else
                            Recent
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="/subscriptions?searchSubscriber={{ $qstring['searchSubscriber'] }}">Recent</a></li>
                        <li><a class="dropdown-item"
                                href="/subscriptions?searchSubscriber={{ $qstring['searchSubscriber'] }}&last=week">Last
                                Week</a></li>
                        <li><a class="dropdown-item"
                                href="/subscriptions?searchSubscriber={{ $qstring['searchSubscriber'] }}&last=month">Last
                                Month</a></li>
                        <li><a class="dropdown-item"
                                href="/subscriptions?searchSubscriber={{ $qstring['searchSubscriber'] }}&last=6months">Last
                                6 Months</a></li>
                        <li><a class="dropdown-item"
                                href="/subscriptions?searchSubscriber={{ $qstring['searchSubscriber'] }}&last=year">Last
                                Year</a></li>
                    </ul>
                </div>
            </div>
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

            <form role="search" method="get">
                <div class="input-group mb-3">
                    <input class="form-control fs-3" name="searchSubscriber" type="search" aria-label="Search"
                        aria-describedby="searchbutton" placeholder="Search..."><input id="" name="last"
                        type="text" value="{{ $qstring['last'] }}" hidden>
                    <button class="btn btn-outline-primary fs-3 px-5" id="searchbutton" type="submit">Search</button>
                    <a class="btn btn-outline-secondary fs-3 px-5" id="clearbutton" type="button"
                        href="/subscriptions?searchSubscriber=">Clear</a>
                </div>
            </form>

            <div class="table-responsive-lg fs-4" style="max-height: 68vh; min-height: 68vh; overflow-y:scroll;">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead style="position: sticky; top: 0;">
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
                                    <a class="btn btn-danger unsubscribe-btn" data-bs-toggle="modal"
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
            {{ $subscribers->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="subscriberDeleteModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="" method="post">
                    @csrf
                    <div class="modal-body ms-2">
                        <h6>Are you sure you want to unsubscribe this subscriber?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger fs-3 btn-delete py-2 px-5" type="submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.unsubscribe-btn').on('click', function() {
                let id = $(this).data('id')
                $('#modalForm').attr('action', '/adminunsubscribe?id=' + id)
            })
        })
    </script>
@endpush
