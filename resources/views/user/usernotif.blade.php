@extends('user.components.userlayout')
@section('resident_content')
    <div class="user-notif">
        <div class="container-xl">
            <div class="user-notif-title">
                <h2>Notifications</h2>
            </div>

            <div class="user-notif-content">
                @for ($i = 0; $i < 30; $i++)
                    <a class="remove-design-notif" href="">
                        <div class="notif-banner">
                            <h6>Sample Title Notification</h6>
                            <p>sample notification description</p>
                            <p class="notif-date">date sample</p>

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
                @endfor


            </div>
        </div>
    </div>
@endsection
