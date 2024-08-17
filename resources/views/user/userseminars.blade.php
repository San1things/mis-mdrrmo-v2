@extends('user.components.userlayout')
@section('resident_content')
    <div class="userseminar" style="min-height: 85vh">
        <div class="container-xl">
            <div class="userseminar-title">
                <center>
                    <h2>Seminars</h2>
                    <p>this are the upcoming seminar:</p>
                </center>
            </div>

            <div class="userseminar-content">
                @foreach ($seminars as $seminar)
                    <div class="seminar-collapse" data-bs-toggle="collapse" data-bs-target="#collapsed-div" aria-expanded="false" aria-controls="collapsed-div">
                        <h4>{{ $seminar->title }}</h4>
                        <p>created_at: {{ $seminar->created_at }}</p>
                    </div>
                    <div class="collapse border border-top-0 collapsed-div" id="collapsed-div">
                        <p class="pb-5">{{ $seminar->description }}</p>
                        <p>Location: {{ $seminar->location }}</p>
                        <p>Starts at: {{ Carbon\Carbon::create($seminar->starts_at)->format('M d, Y || h:ma') }}</p>
                        <div class="seminar-button">
                            @php
                                $userinfo = request()->attributes->get('userinfo');
                                $attendeeCheck = DB::table('tbl_attendees')
                                    ->where('user_id', $userinfo[0])
                                    ->where('seminar_id', $seminar->id)
                                    ->count();
                            @endphp
                            @if ($attendeeCheck >= 1)
                                <a class="btn btn-danger" href="/userunregisterseminar?sid={{ $seminar->id }}">Unregister</a>
                            @elseif ($seminar->status == 'ongoing' || $seminar->status == 'finished')
                                <a class="btn btn-success" href="/userseminarreqcert?sid={{ $seminar->id }}">Request Certificate</a>
                            @else
                                <a class="btn btn-success" href="/userjoinseminar?sid={{ $seminar->id }}">Join Seminar</a>
                            @endif

                            <p>{{ $attendeeCount }} joined this seminar...</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
