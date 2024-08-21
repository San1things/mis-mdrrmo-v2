@extends('user.components.userlayout')
@section('resident_content')
    @php
        $userinfo = request()->attributes->get('userinfo');
        DB::table('tbl_notif')
            ->where('user_id', $userinfo[0])
            ->where('user_type', 'resident')
            ->update([
                'seen' => 1,
            ]);
    @endphp

    <div class="user-notif">
        <div class="container-xl">
            <div class="user-notif-title">
                <h2>Notifications</h2>
            </div>

            <div class="user-notif-content">
                @forelse ($notifications as $notification)
                    <a class="remove-design-notif" href="/{{ $notification->link }}">
                        <div class="notif-banner">
                            <h6>{{ $notification->title }}</h6>
                            <p>{{ $notification->description }}</p>
                            <p class="notif-date">{{ \Carbon\Carbon::create($notification->created_at)->format('D h:ma - m/d/y ') }}</p>

                            <div class="btn-group san1-notif-settings">
                                <a class="btn dropdown-toggle fs-3 pe-3" data-bs-toggle="dropdown" type="button"
                                    aria-expanded="false">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button class="dropdown-item fs-4" type="button">Remove Notification</button></li>
                                </ul>
                            </div>

                        </div>
                    </a>
                @empty
                    <center>
                        <div class="no-notif-text">
                            <h5>No notifications availabale...</h5>
                        </div>
                    </center>
                @endforelse
            </div>
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    @endsection
