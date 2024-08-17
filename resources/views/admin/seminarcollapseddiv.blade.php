@extends('admin.modal')


@section('content')
    <center>
        <p class="fs-3">{{ $seminar->description }}</p>
        <p>Location: {{ $seminar->location }}</p>
    </center>


    <div class="seminar-attendees">
        <h6>Attendees({{ $attendeesCount }}):</h6>
        <div class="input-group m-3">
            <input class="form-control fs-3" type="search" aria-label="Search" aria-describedby="search-btn" placeholder="Search...">
            <button class="btn btn-outline-primary fs-3 px-4 py-2" id="search-btn" type="button">Search</button>
        </div>

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
