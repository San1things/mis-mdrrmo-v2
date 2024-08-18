@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Seminars</h1>
                <p>All upcoming seminars.</p>
            </div>
            <div class="header-export pe-3">

                <a class="btn btn-primary px-4 py-3 createseminar-btn" data-bs-toggle="modal" data-bs-target="#seminarsAddUpdateModal" href="#">
                    <i class="bi bi-person-fill-add"></i>
                    <span>Create Seminar</span>
                </a>
            </div>
        </div>

        <div class="admin-content">
            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fs-2 py-5 fade show alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}" role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : '' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset


            <h3>Seminars({{ $seminarCount }})</h3>

            @foreach ($seminars as $seminar)
                <div class="seminar-collapse border border-dark" data-bs-toggle="collapse" data-bs-target="#collapsed-div{{ $seminar->id }}" aria-expanded="false"
                    aria-controls="collapsed-div">
                    <h6>{{ $seminar->title }}</h6>
                    <p>Start date: {{ $seminar->starts_at }}</p>
                    <p class="click-details-text">click for more details...</p>
                    <div class="adminseminar-btns" data-state="hide" style="display: none">
                        <button class="btn btn-primary fs-3 px-3 seminar-edit-btn" data-sid="{{ $seminar->id }}" data-stitle="{{ $seminar->title }}" data-sdescription="{{ $seminar->description }}" data-slocation="{{ $seminar->location }}" data-sstart="{{ $seminar->starts_at }}" data-bs-toggle="modal" data-bs-target="#seminarsAddUpdateModal">Edit Seminar</button>
                        <button class="btn btn-success fs-3 px-3">Start Seminar</button>
                    </div>
                </div>
                <div class="collapse border border-top-0 p-5" id="collapsed-div{{ $seminar->id }}">
                    <iframe src="/seminarcollapseddiv?id={{ $seminar->id }}" style="border: none" width="100%" height="500px"></iframe>
                </div>
            @endforeach

        </div>
    </div>

    <div class="modal fade" id="seminarsAddUpdateModal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
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
                            <input class="form-control fs-3" id="seminartitle" name="seminartitle" type="text" placeholder="Seminar Title">
                        </div>
                        <div class="mb-3">
                            <label class="fomr-label fs-3" for="floatingInput">Seminar Description:</label>
                            <textarea class="form-control fs-3" id="seminardescription" name="seminardescription" style="height: 150px" placeholder="Seminar Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-3" for="form-label fs-4">Seminar Location:</label>
                            <input class="form-control fs-3" id="seminarlocation" name="seminarlocation" type="text" placeholder="Seminar Location">
                        </div>
                        <div class="mb-3">
                            <span class="fs-4" id="itemexpiredlabel">Start Date:</span>
                            <input class="form-control fs-3" id="startdate" name="startdate" type="datetime-local"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary fs-3 px-5 btn-save" type="submit">Create Seminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.seminar-edit-btn').on('click', function() {
                    let id = $(this).data('sid');
                    $('#seminartitle').val($(this).data('stitle'))
                    $('#seminardescription').val($(this).data('sdescription'))
                    $('#seminarlocation').val($(this).data('slocation'))
                    $('#startdate').val($(this).data('sstart'))
                    $('.btn-save').text('Update Seminar')
                    $('#modalForm').attr('action', 'adminupdateseminar?sid=' + id)
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
            })
        </script>
    @endpush
@endsection
