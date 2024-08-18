@extends('publiclayout')
@section('public_content')
    <section class="container-xl announcements-title">
        <h2>Don't get yourself outdated!</h2>
        <h6>Here's our latest announcements.</h6>
    </section>

    <section class="announcements-content">
        <div class="container-xl">
            @foreach ($announcements as $announcement)
                <div class="announcements-container">
                    <center>
                        <h6>Announcement Type: {{ $announcement->announcement_type }}</h6>
                        @if ($announcement->announcement_link == null)
                            <div class="announcements-image">
                                <img src="{{ asset('images/uploadedpics/' . $announcement->announcement_image) }}"
                                    alt="">
                            </div>
                        @else
                            <div class="announcements-image">
                                <a href="{{ $announcement->announcement_link }}">
                                    <img src="{{ asset('images/uploadedpics/' . $announcement->announcement_image) }}"
                                        alt="">
                                </a>
                            </div>
                        @endif

                        <p class="announcements-datetime">announced at: {{ Carbon\Carbon::create($announcement->created_at)->format('M d,Y || h:ia') }}</p>
                        <h4>{{ $announcement->announcement_name }}</h4>
                        <p>
                            {{ $announcement->announcement_description }}
                        </p>
                    </center>
                </div>
            @endforeach
        </div>
    </section>

@endsection
