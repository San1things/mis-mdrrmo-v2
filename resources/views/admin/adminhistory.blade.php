@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Seminars</h1>
                <p>This is where all of the seminar's history. ({{ $hseminarCount }})</p>
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
                @foreach ($historyseminars as $hseminar)
                    <div class="seminar-collapse" data-bs-toggle="collapse"
                        data-bs-target="#collapsed-div{{ $hseminar->id }}" aria-expanded="false"
                        aria-controls="collapsed-div"
                        style="
                        @if ($hseminar->status == 'finished')
                        background-color: #ceffd8;
                        color: black;
                        @elseif($hseminar->status == 'cancelled')
                        background-color: #ff9595;
                        @endif">
                        <h6>{{ $hseminar->title }}
                            @if ($hseminar->status == 'finished')
                                (finished)
                            @elseif ($hseminar->status == 'cancelled')
                                (cancelled)
                            @endif
                        </h6>
                        <p>{{ Carbon\Carbon::create($hseminar->updated_at)->format('M d, Y') }}</p>
                    </div>
                    <div class="collapse border border-top-0" id="collapsed-div{{ $hseminar->id }}">
                        <iframe src="/historycollapseddiv?id={{ $hseminar->id }}" style="border: none" width="100%"
                            height="400px"></iframe>
                    </div>
                @endforeach
            </div>
            {{ $historyseminars->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
