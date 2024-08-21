@extends('admin.components.adminlayout')
@section('content')
    @php
        $userinfo = request()->attributes->get('userinfo');
        DB::table('tbl_notif')
            ->where('user_id', $userinfo[0])
            ->where('user_type', 'org')
            ->update([
                'seen' => 1,
            ]);
    @endphp

    <div class="container-xl mt-3">
        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark">
            <div class="header-title p-2 flex-grow-1">
                <h1>Notifications</h1>
            </div>
        </div>

        @isset($alert)
            <center>
                <div class="alert alert-dismissible fade show fs-3 alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                    role="alert">
                    {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : 'error' }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            </center>
        @endisset

        <div class="admin-content-notif">
            @forelse ($notifications as $notification)
                <a class="notif-remove-design" href="{{ $notification->link }}">
                    <div class="notif-banner">
                        <h6>{{ $notification->title }}</h6>
                        <p>{{ $notification->description }}</p>
                        <p class="notif-date">
                            {{ \Carbon\Carbon::create($notification->created_at)->format('D h:ma - m/d/y') }}</p>

                        <div class="btn-group san1-notif-settings">
                            <a class="btn dropdown-toggle fs-3 pe-3" data-bs-toggle="dropdown" type="button"
                                aria-expanded="false">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item fs-3" type="button"
                                        href="/adminremovenotif?id={{ $notification->id }}">Remove Notification</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
            @empty
                <center>
                    <div class="no-notif-text" style="padding: 30vh 0; color: gray;">
                        <h4>No notifications available...</h4>
                    </div>
                </center>
            @endforelse
        </div>
    </div>
@endsection
