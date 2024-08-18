@extends('admin.modal')


@section('content')
    <center>
        <p class="fs-3">{{ $seminar->description }}</p>
        <p class="border-dark border-bottom pb-3">Location: {{ $seminar->location }}</p>
    </center>

    <div class="seminar-attendees">
        <h6>Attendees({{ $attendeesCount }}):</h6>
        <form method="get">
            <div class="input-group m-3 px-5 pb-3">
                <input name="id" type="text" value="{{ $seminar->id }}" hidden>
                <input class="form-control fs-3" name="searchAttendee" type="search" placeholder="Search...">
                <button class="btn btn-outline-primary fs-3 px-4 py-2" id="search-btn" type="submit">Search</button>
                <a class="btn btn-outline-secondary fs-3 px-4 py-2" id="clear-btn" href="/seminarcollapseddiv?id={{ $seminar->id }}">Clear</a>
            </div>
        </form>

        @isset($alert)
            <center>
                <div class="alert alert-dismissible fs-2 py-5 fade show alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}" role="alert">
                    {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : '' }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            </center>
        @endisset

        <div class="container">
            <div class="row g-2">

                @foreach ($attendees as $attendee)
                    <div class="col-5 position-relative pt-5 pe-5 ps-3 border m-3">
                        <h6>{{ $attendee->firstname }} {{ $attendee->lastname }}</h6>
                        <p>lived in: {{ $attendee->address }}</p>
                        <p>registered at: {{ Carbon\Carbon::create($attendee->created_at)->format('M d, Y || h:ma') }}</p>
                        <p class="position-absolute top-0 left-0 mt-1">user #: {{ $attendee->user_id }}</p>
                        @if ($seminar->status == 'upcoming')
                            <div class="btn btn-danger fs-2 position-absolute top-0 end-0 me-3 mt-3 remove-attendee-btn " id="{{ $attendee->user_id }}" data-u data-sid="{{ $seminarid }}" data-bs-toggle="modal"
                                data-bs-target="#attendeeRemoveModal">
                                <i class="bi bi-person-x-fill"></i>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="modal fade" id="attendeeRemoveModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="" method="POST">
                    @csrf
                    <div class="modal-body ms-2">
                        <h6>Are you sure you want to remove this attendee?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger fs-3 btn-delete" type="submit">Yes, remove it.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.remove-attendee-btn').on('click', function() {
                let uid = $(this).data('uid')
                let sid = $(this).data('sid')
                console.log(sid)
                $('#modalForm').attr('action', '/adminremoveattendee?id=' + id + '&sid=' + sid)
            })
        })
    </script>
@endpush
