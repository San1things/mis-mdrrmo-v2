@extends('admin.components.adminlayout')
@section('content')

    @php
        DB::table('tbl_messages')
        ->update([
            'seen' => 1,
        ]);
    @endphp

    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Messages</h1>
                <p>Inbox. ({{ $messageCount }})</p>
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
                                <a class="nav-link" href="?sender=&searchMessage={{ $qstring['searchMessage'] }}"
                                    aria-current="page"
                                    style="{{ request('sender') === null ? 'font-weight: 700;' : '' }}">View
                                    All</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?sender=user&searchMessage={{ $qstring['searchMessage'] }}"
                                    style="{{ request('sender') === 'user' ? 'font-weight: 700;' : '' }}">User Messages</a>
                            </li>
                            <li class="nav-item border border-start-0">
                                <a class="nav-link" href="?sender=unknown&searchMessage={{ $qstring['searchMessage'] }}"
                                    style="{{ request('sender') === 'unknown' ? 'font-weight: 700;' : '' }}">Public
                                    Messages</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search" method="get">
                            <input name="category" type="hidden" value="{{ $qstring['sender'] }}">
                            <input class="form-control me-3 fs-4" name="searchMessage" type="search" value=""
                                aria-label="Search" placeholder="Search">
                            <button class="btn btn-outline-primary me-2 fs-4" type="submit">Search</button>
                            <a class="btn btn-outline-secondary fs-4" href="?category=&searchMessage=">Clear</a>
                        </form>
                    </div>
                </div>
            </nav>

            <div class="admin-messages-container" style="max-height:67vh; min-height:67vh; overflow-y:scroll;">
                @foreach ($messages as $message)
                    <div class="message-collapse" data-bs-toggle="collapse"
                        data-bs-target="#collapsed-div{{ $message->id }}" data-collapse-show="true" aria-expanded="false"
                        aria-controls="collapsed-div"
                        style="{{ $message->replied == 1 ? 'background-color: #8cddb7' : '' }}">
                        <h6>{{ $message->name }} {{ $message->replied == 1 ? '(replied)' : '' }}</h6>
                        <p class="mc-cut-text">{{ Illuminate\Support\Str::limit($message->message, 100) }}...</p>
                        <p class="mc-date-time">
                            @php
                                $sent = Carbon\Carbon::parse($message->created_at);
                                $now = Carbon\Carbon::now();
                                $daysPassed = $sent->diffInDays($now);
                                $hoursPassed = $sent->diffInHours($now);
                                $minutesPassed = $sent->diffInMinutes($now);
                            @endphp

                            @if ($daysPassed === 0)
                                @if ($hoursPassed === 0)
                                    @if ($minutesPassed === 0)
                                        Just now
                                    @elseif ($minutesPassed === 1)
                                        A minute ago
                                    @else
                                        {{ $minutesPassed }} minutes ago
                                    @endif
                                @elseif ($hoursPassed === 1)
                                    An hour ago
                                @else
                                    {{ $hoursPassed }} hours ago
                                @endif
                            @elseif ($daysPassed === 1)
                                Yesterday
                            @elseif ($daysPassed <= 7)
                                {{ $daysPassed }} days ago
                            @elseif ($daysPassed > 7)
                                A week ago
                            @elseif ($daysPassed > 14)
                                {{ $sent->format('M d, Y') }}
                            @endif
                        </p>
                    </div>

                    <div class="collapse border border-top-0 px-5 pb-2" id="collapsed-div{{ $message->id }}"
                        style="position: relative;">
                        <p style="position: absolute;top: 10px;right: 20px;font-size: 1.3rem;color: gray;">
                            @if ($message->replied == 1)
                                admin replied at: {{ Carbon\Carbon::create($message->updated_at)->format('h:ma. m/d/y') }}
                            @else
                                {{ Carbon\Carbon::create($message->created_at)->format('D, h:ma. m/d/y') }}
                            @endif
                        </p>
                        <p style="font-size: 1.7rem; color:gray;">email: {{ $message->email }}</p>
                        <p>{{ $message->message }}</p>

                        @if ($message->replied == 0)
                            <div class="reply-container position-relative mb-3" style="display: none">
                                <form action="/adminmessagereply?id={{ $message->id }}" method="POST">
                                    @csrf
                                    <p style="color: gray">Reply: </p>
                                    <textarea class="form-control" id="" name="messagereply" style="width: 100%;font-size: 1.7rem;"
                                        placeholder="Write something..." required></textarea>
                                    <button class="btn btn-success fs-3 px-5 py-3 mt-3 position-absolute end-0"
                                        type="submit">
                                        <i class="bi bi-reply-fill"></i> Reply
                                    </button>
                                </form>
                            </div>

                            <button class="btn btn-primary fs-3 px-5 py-3 mb-3 san1-message-reply" data-reply-show="false">
                                Reply
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        {{ $messages->links('pagination::bootstrap-5') }}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.message-collapse').on('click', function() {
                let collapseShow = $(this).data('collapse-show')
                if (collapseShow === 'true') {
                    $(this).find('.mc-cut-text').show()
                    $(this).find('.mc-date-time').show()
                    $(this).data('collapse-show', 'false')
                } else {
                    $(this).find('.mc-cut-text').hide()
                    $(this).find('.mc-date-time').hide()
                    $(this).data('collapse-show', 'true')
                }
            })

            $('.san1-message-reply').on('click', function() {
                let show = $(this).data('reply-show')
                if (show === 'false') {
                    $(this).prev('.reply-container ').attr('style', 'display: none');
                    $(this).text('Reply');
                    $(this).data('reply-show', 'true')
                } else {
                    $(this).prev('.reply-container ').attr('style', 'display: block');
                    $(this).text('Cancel');
                    $(this).data('reply-show', 'false')
                }
            })
        })
    </script>
@endpush
