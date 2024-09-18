@extends('admin.components.modal')

@section('content')
    <center>
        <p class="fs-3">{{ $seminar->description }}</p>
        <p class="border-dark border-bottom pb-3">Location: {{ $seminar->location }}</p>
    </center>

    <div class="seminar-attendees">
        <h6>People attended({{ $attendeesCount }}):</h6>
        <form method="get">
            <div class="input-group m-3 px-5 pb-3">
                <input name="id" type="text" value="{{ $seminar->id }}" hidden>
                <input class="form-control fs-3" name="searchAttendee" type="search" placeholder="Search...">
                <button class="btn btn-outline-primary fs-3 px-4 py-2" id="search-btn" type="submit">Search</button>
                <a class="btn btn-outline-secondary fs-3 px-4 py-2" id="clear-btn"
                    href="/historycollapseddiv?id={{ $seminar->id }}">Clear</a>
            </div>
        </form>

        @isset($alert)
            <center>
                <div class="alert alert-dismissible fs-2 fade show alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                    role="alert">
                    {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : '' }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            </center>
        @endisset

        <div class="container">
            <div class="row g-2">
                <div class="table-responsive-lg fs-4">
                    <table class="table table table-light table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 10%" scope="col-1">User ID</th>
                                <th style="width: 20%" scope="col-1">First Name</th>
                                <th style="width: 20%" scope="col-1">Last Name</th>
                                <th style="width: 30%" scope="col-1">Lived in:</th>
                                <th style="width: 10%" scope="col-1">Certificate</th>
                                <th style="width: 5%" scope="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendees as $attendee)
                                <tr
                                    class="
                                @if ($attendee->cert_request == 'req') table-primary
                                @elseif($attendee->cert_request == 'sent')
                                table-success @endif
                                ">
                                    <td>{{ $attendee->user_id }}</td>
                                    <td>{{ $attendee->firstname }}</td>
                                    <td>{{ $attendee->lastname }}</td>
                                    <td>{{ $attendee->address }}</td>
                                    <td>
                                        @if ($attendee->cert_request == 'req')
                                            Requested
                                        @elseif ($attendee->cert_request == 'sent')
                                            Sent
                                        @else
                                            No request
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendee->cert_request == 'req')
                                            <a class="btn btn-primary sendcert-btn fs-5"
                                                data-userid="{{ $attendee->user_id }}"
                                                data-seminarid="{{ $seminar->id }}" data-bs-toggle="modal"
                                                data-bs-target="#sendCertModal" href="#"> Send Certificate
                                            </a>
                                        @elseif ($attendee->cert_request == 'not')
                                            <button class="btn btn-danger sendcert-btn fs-5" disabled> Send Certificate
                                            </button>
                                        @else
                                        <button class="btn btn-success sendcert-btn fs-5" disabled> Certificate is sent!
                                        </button>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <center>
                                    <h3>NO ATTENDEES FOUND!</h3>
                                </center>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sendCertModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="" method="post">
                    @csrf
                    <div class="modal-body ms-2">
                        <h6>Are you sure you want to send a certificate to this attendee?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary fs-3 px-5 btn-delete" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.sendcert-btn').on('click', function() {
                let uid = $(this).data('userid')
                let sid = $(this).data('seminarid')
                $('#modalForm').attr('action', '/adminsendcertificate?sid=' + sid + '&uid=' + uid)
            })
        })
    </script>
@endpush
