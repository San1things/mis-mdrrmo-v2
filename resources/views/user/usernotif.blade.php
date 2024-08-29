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

            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fade show fs-3 alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : 'error' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset

            <div class="user-notif-title">
                <h2>Notifications</h2>
            </div>

            <div class="user-notif-content">
                @forelse ($notifications as $notification)
                    <a class="remove-design-notif" href="{{ $notification->link }}">
                        <div class="notif-banner">
                            <h6>{{ $notification->title }}</h6>
                            <p>{{ Illuminate\Support\Str::limit($notification->description, 100) }}...</p>
                            <p class="notif-date">
                                {{ \Carbon\Carbon::create($notification->created_at)->format('D h:ma - m/d/y') }}</p>

                            <div class="btn-group san1-notif-settings">
                                <a class="btn dropdown-toggle fs-3 pe-3" data-bs-toggle="dropdown" type="button"
                                    aria-expanded="false">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item fs-4" type="button"
                                            href="/userremovenotif?id={{ $notification->id }}">Remove Notification</a></li>
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
