@extends('user.components.userlayout')
@section('resident_content')
    <div class="userseminar" style="min-height: 85vh">
        <div class="container-xl">
            <div class="userseminar-title">
                <center>
                    <h1>Seminars:</h1>
                    <p>This are the upcoming seminars from our organization. Join us and learn different knowledge from our
                        org.</p>
                </center>
            </div>

            @isset($alert)
                <center>
                    <div class="alert alert-dismissible fade show fs-3 py-5 alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                        role="alert">
                        {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : 'error' }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                </center>
            @endisset

            <div class="userseminar-content">
                @foreach ($seminars as $seminar)
                    @php
                        $userinfo = request()->attributes->get('userinfo');
                        $attendeeCheck = DB::table('tbl_attendees')
                            ->where('user_id', $userinfo[0])
                            ->where('seminar_id', $seminar->id)
                            ->count();

                            $attendeeCount = DB::table('tbl_attendees')
                            ->where('seminar_id', $seminar->id)
                            ->count();
                    @endphp

                    @if ($seminar->status == 'finished')
                        @if ($attendeeCheck >= 1)
                            <div class="seminar-collapse bg-success bg-gradient text-white bg-opacity-75"
                                data-bs-toggle="collapse" data-bs-target="#collapsed-div{{ $seminar->id }}"
                                aria-expanded="false" aria-controls="collapsed-div">
                                <h4>{{ $seminar->title }} (Finished)</h4>
                                <p>Get your certificate here now!</p>
                            </div>
                        @else
                            <div class="seminar-collapse bg-success bg-gradient text-white bg-opacity-75"
                                style="cursor: default">
                                <h4>{{ $seminar->title }} (Finished)</h4>
                                <p>It
                                    's so sad you didn't make it. Better join us next time and let's learn be safe and
                                    ready all the time!</p>
                            </div>
                        @endif
                    @elseif ($seminar->status == 'ongoing')
                        <div class="seminar-collapse bg-primary bg-gradient text-white bg-opacity-75""
                            data-bs-toggle="collapse" data-bs-target="#collapsed-div{{ $seminar->id }}"
                            aria-expanded="false" aria-controls="collapsed-div">
                            <h4>{{ $seminar->title }} (Ongoing)</h4>
                            <p>Started at: {{ Carbon\Carbon::create($seminar->starts_at)->format('M d, Y, h:ia') }}</p>
                        </div>
                    @else
                        <div class="seminar-collapse" data-bs-toggle="collapse"
                            data-bs-target="#collapsed-div{{ $seminar->id }}" aria-expanded="false"
                            aria-controls="collapsed-div">
                            <h4>{{ $seminar->title }} {{ $attendeeCheck >= 1 ? '(Registered)' : '' }}</h4>
                            <p>Posted: {{ Carbon\Carbon::create($seminar->created_at)->format('M d, Y, h:ia') }}</p>
                        </div>
                    @endif

                    <div class="collapse border border-top-0 collapsed-div" id="collapsed-div{{ $seminar->id }}">
                        <p class="pb-5">{{ $seminar->description }}</p>
                        <p style="{{ $attendeeCheck >= 1 ? 'font-weight: bolder; color: #5cb85c;' : '' }}">Location:
                            {{ $seminar->location }}</p>
                        <p>{{ $seminar->status == 'ongoing' || $seminar->status == 'finished' ? 'Seminar started at' : 'Starts at' }}:
                            {{ Carbon\Carbon::create($seminar->starts_at)->format('M d, Y || h:ma') }}</p>
                        @if ($seminar->status == 'upcoming')
                            <div class="seminar-button">
                                <center>
                                    @if ($attendeeCheck >= 1)
                                        <a class="btn btn-danger"
                                            href="/userunregisterseminar?sid={{ $seminar->id }}">Unregister</a>
                                    @else
                                        <a class="btn btn-success" href="/userjoinseminar?sid={{ $seminar->id }}">Join
                                            Seminar</a>
                                    @endif
                                    <p>{{ $attendeeCount }} joined this seminar...</p>
                                </center>
                            </div>
                        @elseif ($seminar->status == 'ongoing')
                            <div class="seminar-button">
                                <p>The seminar is ongoing. {{ $attendeeCount }} attendees are present.</p>
                            </div>
                        @elseif ($seminar->status == 'finished')
                            <div class="seminar-button">
                                <center>
                                    @php
                                        $requestcheck = DB::table('tbl_attendees')
                                            ->where('seminar_id', $seminar->id)
                                            ->where('user_id', $userinfo[0])
                                            ->first();
                                    @endphp
                                    @if ($requestcheck->cert_request == 'req')
                                        <p>Certificate has been requested!</p>
                                    @elseif ($requestcheck->cert_request == 'sent')
                                        <p style="color: #5cb85c">Certificate has been sent!</p>
                                    @else
                                        <a class="btn btn-success"
                                            href="/userseminarreqcert?sid={{ $seminar->id }}&uid={{ $userinfo[0] }}">Request
                                            Certificate</a>
                                        <p>Congratualtions! Get your certificate now!</p>
                                    @endif
                                </center>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('userscripts')
    <script></script>
@endpush
