@extends('publiclayout')
@section('public_content')
    <section class="container-xl wrapper announcements-title">
            <h2>Don't get yourself outdated!</h2>
            <h6>Here's our latest announcements.</h6>
    </section>

    <section class="announcements-content">
        <div class="container-xl wrapper">
            <center>
                <img src="{{ asset('images/publicpics/mdrrmopic11.jpg') }}" alt="">
                <p class="announcements-datetime">announced at: SAMPLE DATETIME</p>
                <h4>SAMPLE ANNOUNCEMENT TITLE</h4>
                <p>sample description
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce venenatis arcu dolor, vitae consequat
                    velit sollicitudin eget. Pellentesque eu condimentum turpis. In suscipit vel elit ut mattis. Sed dictum
                    erat et arcu aliquet vehicula. Integer ullamcorper auctor blandit. Sed viverra eu purus in efficitur.
                    Quisque ac placerat elit, ac accumsan nunc. Ut rhoncus, turpis eu molestie tristique, quam ex
                    pellentesque mauris, a commodo nibh augue et mauris. Donec volutpat congue auctor.</p>
            </center>
        </div>
    </section>
@endsection
