@extends('admin.components.adminlayout')
@section('content')
    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark position-relative">
            <div class="header-title p-2 flex-grow-1">
                <h1>Seminar History</h1>
                <p>This is where all of the seminar's history. ({{ $hseminarCount }})</p>
            </div>
            <div class="header-export pe-3">

                <a class="btn btn-primary px-4 py-2 printseminar-btn"
                    href="{{ route('generate-shistory-pdf', request()->query()) }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Export</span>
                </a>

                <div class="btn-group position-absolute bottom-0 end-0 pe-4 pb-2">
                    <button class="btn btn-lite dropdown-toggle fs-3" data-bs-toggle="dropdown" type="button"
                        aria-expanded="false">
                        @if (request()->query('last') == 'week')
                            Last Week
                        @elseif (request()->query('last') == 'month')
                            Last Month
                        @elseif (request()->query('last') == '6months')
                            Last 6 Months
                        @elseif (request()->query('last') == 'year')
                            Last Year
                        @else
                            Recent
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/adminhistory">Recent</a></li>
                        <li><a class="dropdown-item" href="/adminhistory?last=week">Last Week</a></li>
                        <li><a class="dropdown-item" href="/adminhistory?last=month">Last
                                Month</a></li>
                        <li><a class="dropdown-item" href="/adminhistory?last=6months">Last
                                6 Months</a></li>
                        <li><a class="dropdown-item" href="/adminhistory?last=year">Last
                                Year</a></li>
                    </ul>
                </div>
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
                @forelse ($historyseminars as $hseminar)
                    <div class="seminar-collapse" data-bs-toggle="collapse"
                        data-bs-target="#collapsed-div{{ $hseminar->id }}" aria-expanded="false"
                        aria-controls="collapsed-div"
                        style="
                        @if ($hseminar->status == 'finished') background-color: #D1E7DD;
                        color: black;
                        @elseif($hseminar->status == 'cancelled')
                        background-color: #ff9595; @endif">
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
                @empty
                    <center>
                        <div class="no-notif-text" style="padding: 30vh 0; color: gray;">
                            <h4>No History...</h4>
                        </div>
                    </center>
                @endforelse
            </div>
            {{ $historyseminars->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
