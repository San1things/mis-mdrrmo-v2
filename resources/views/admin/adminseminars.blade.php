@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Seminars</h1>
                <p>This are all upcoming seminars. ({{ $seminarCount }})</p>
            </div>
            <div class="header-export pe-3">

                <a class="btn btn-primary px-4 py-3 createseminar-btn" data-bs-toggle="modal"
                    data-bs-target="#seminarsAddUpdateModal" href="#">
                    <i class="bi bi-person-fill-add"></i>
                    <span>Create Seminar</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fs-2 py-5 fade show alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : '' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset

            <div class="admin-seminar-container" style="max-height:74vh; min-height:74vh; overflow-y:scroll;">
                @foreach ($seminars as $seminar)
                    <div class="seminar-collapse" data-bs-toggle="collapse"
                        data-bs-target="#collapsed-div{{ $seminar->id }}" aria-expanded="false"
                        aria-controls="collapsed-div">
                        <h6>{{ $seminar->title }} {{ $seminar->status == 'ongoing' ? '(seminar is ongoing...)' : '' }}</h6>
                        @if ($seminar->status == 'ongoing')
                            <p style="color: green">Started at:
                                {{ Carbon\Carbon::create($seminar->updated_at)->format('M d, Y, h:m a') }}</p>
                        @else
                            <p>Start date: {{ Carbon\Carbon::create($seminar->starts_at)->format('M d, Y, h:m a') }}</p>
                        @endif
                        <p class="click-details-text">click for more details...</p>
                        <div class="adminseminar-btns" data-state="hide" style="display: none">
                            @if ($seminar->status == 'ongoing')
                                <button class="btn btn-danger fs-3 px-3 seminar-cancel-btn" data-sid="{{ $seminar->id }}"
                                    data-bs-toggle="modal" data-bs-target="#seminarsStartEndCancelModal">Cancel
                                    Seminar</button>
                                <button class="btn btn-primary fs-3 px-3 seminar-end-btn" data-sid="{{ $seminar->id }}"
                                    data-bs-toggle="modal" data-bs-target="#seminarsStartEndCancelModal">End
                                    Seminar</button>
                            @else
                                <button class="btn btn-primary fs-3 px-3 seminar-edit-btn" data-sid="{{ $seminar->id }}"
                                    data-stitle="{{ $seminar->title }}" data-sdescription="{{ $seminar->description }}"
                                    data-slocation="{{ $seminar->location }}" data-sstart="{{ $seminar->starts_at }}"
                                    data-bs-toggle="modal" data-bs-target="#seminarsAddUpdateModal">Edit Seminar</button>
                                <button class="btn btn-success fs-3 px-3 seminar-start-btn" data-sid="{{ $seminar->id }}"
                                    data-bs-toggle="modal" data-bs-target="#seminarsStartEndCancelModal">Start
                                    Seminar</button>
                            @endif

                        </div>
                    </div>
                    <div class="collapse border border-top-0 p-5" id="collapsed-div{{ $seminar->id }}">
                        <iframe src="/seminarcollapseddiv?id={{ $seminar->id }}" style="border: none" width="100%"
                            height="400px"></iframe>
                    </div>
                @endforeach
            </div>
            {{ $seminars->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="modal fade" id="seminarsAddUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle"></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="modalForm" action="/admincreateseminar" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fs-3" for="form-label fs-4">Seminar Title:</label>
                            <input class="form-control fs-3" id="seminartitle" name="seminartitle" type="text"
                                placeholder="Seminar Title">
                        </div>
                        <div class="mb-3">
                            <label class="fomr-label fs-3" for="floatingInput">Seminar Description:</label>
                            <textarea class="form-control fs-3" id="seminardescription" name="seminardescription" style="height: 150px"
                                placeholder="Seminar Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-3" for="form-label fs-4">Seminar Location:</label>
                            <input class="form-control fs-3" id="seminarlocation" name="seminarlocation" type="text"
                                placeholder="Seminar Location">
                        </div>
                        <div class="mb-3">
                            <span class="fs-4" id="itemexpiredlabel">Start Date:</span>
                            <input class="form-control fs-3" id="startdate" name="startdate"
                                type="datetime-local"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary fs-3 px-5 btn-save seminar-add-btn" type="submit">Create
                            Seminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="seminarsStartEndCancelModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <form id="seminarmodalForm" action="" method="post">
                    @csrf
                    <div class="modal-body ms-2">
                        <h6 id="startendcanceltext">Are you sure you want to start this seminar?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark fs-3 px-5 py-2 btn-addendcancel" type="submit">Start Seminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                $('.createseminar-btn').on('click', function() {
                    $('#seminartitle').val('')
                    $('#seminardescription').val('')
                    $('#seminarlocation').val('')
                    $('#startdate').val('')
                    $('.btn-save').text('Create Seminar')
                    $('#modalForm').attr('action', 'admincreateseminar')
                })

                $('.seminar-edit-btn').on('click', function() {
                    let id = $(this).data('sid');
                    $('#seminartitle').val($(this).data('stitle'))
                    $('#seminardescription').val($(this).data('sdescription'))
                    $('#seminarlocation').val($(this).data('slocation'))
                    $('#startdate').val($(this).data('sstart'))
                    $('.btn-save').text('Update Seminar')
                    $('#modalForm').attr('action', 'adminupdateseminar?sid=' + id)
                })

                $('.seminar-start-btn').on('click', function() {
                    let id = $(this).data('sid');
                    $('#seminarmodalForm').attr('action', 'adminstartseminar?sid=' + id)
                })

                $('.seminar-end-btn').on('click', function() {
                    let id = $(this).data('sid');
                    $('#startendcanceltext').text('Are you sure you want to finish this seminar?')
                    $('.btn-addendcancel').text('End Seminar')
                    $('#seminarmodalForm').attr('action', 'adminendseminar?sid=' + id)
                })

                $('.seminar-cancel-btn').on('click', function() {
                    let id = $(this).data('sid');
                    $('#startendcanceltext').text('Are you sure you want to cancel this seminar?')
                    $('.btn-addendcancel').text('Cancel Seminar')
                    $('#seminarmodalForm').attr('action', 'admincancelseminar?sid=' + id)
                })

                $(".seminar-collapse").on('click', function() {
                    let child = $(this).find('.adminseminar-btns');
                    let childtext = $(this).find('.click-details-text');

                    let state = child.data('state')
                    if (state == 'hide') {
                        childtext.text('')
                        child.attr('style', 'display: block')
                        child.data('state', 'show')
                    } else {
                        childtext.text('Click for more details...')
                        child.attr('style', 'display: none')
                        child.data('state', 'hide')
                    }
                })

                $("#modalForm").on('submit', function() {
                    $(".seminar-add-btn").prop("disabled", true).text("Saving...");
                });
            })
        </script>
    @endpush
@endsection
