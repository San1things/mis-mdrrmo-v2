@extends('user.components.userlayout')
@section('resident_content')
    <section class="home-title">
        <div class="container-xl">
            <div class="title-section">
                <center>
                    <h1>Hi {{ $user->firstname }}! This is the official website of</h1>
                    <h1>Municipal Disaster Risk Reduction and Management Office</h1>
                    <h1>Morong, Rizal</h1>
                </center>
            </div>
        </div>
    </section>

    <section class="home-about">
        <div class="container-xl home-about-flexbox">
            <div class="home-about-image">
                <img src="{{ asset('images/publicpics/mdrrmopic3.jpg') }}" alt="abtpic">
            </div>
            <div class="home-about-text">
                <h3>About MDRRMO Morong, Rizal.</h3>
                <p>The primary objective MDRRMO is to ensure effective and efficient implementation of civil protection
                    programme through an integrated, multi-sectoral and community based approach and strategies for the
                    protection and preservation of life, property and environment.</p>
                <a class="btn btn-secondary home-about-btn mt-3" href="/userabout">READ MORE</a>
            </div>
        </div>
    </section>

    <section class="home-services">
        <div class="container-xl">
            <center class="home-services-text">
                <h1>Services</h1>
                <p>At the Municipality Disaster Risk Reduction and Management Office of Morong Rizal, we pride ourselves on
                    providing comprehensive emergency response services
                    to ensure the safety, health, and well-being of our community. Our dedicated team is equipped and ready
                    to handle a wide range of emergency situations, offering the different kind of safety critical services.
                </p>
                <a class="btn btn-primary home-services-btn" href="/userservices">CHECK OUR SERVICES</a>
            </center>
            <div class="home-services-images">
                <img src="{{ asset('images/publicpics/alarm.png') }}" alt="">
                <img src="{{ asset('images/publicpics/first-aid-kit.png') }}" alt="">
                <img src="{{ asset('images/publicpics/disaster.png') }}" alt="">
                <img src="{{ asset('images/publicpics/rescue.png') }}" alt="">
                <img src="{{ asset('images/publicpics/ambulance.png') }}" alt="">
                <img src="{{ asset('images/publicpics/training.png') }}" alt="">
            </div>
        </div>
    </section>

    <section class="home-subscribe">
        <div class="container-xl">
            <center>
                <h4>Since you have an account, you dont need to subscribe anymore! You will receive all update news about us on this email:</h4>
                <div class="input-group">
                    <input class="form-control" name="homeemail" type="email" value="{{ $user->email }}"
                        aria-label="Email" aria-describedby="button-addon2" placeholder="Email" required="required"
                        disabled>
                </div>
            </center>
        </div>
    </section>

    <section class="home-sitemap">
        <div class="container-xl home-sitemap-flexbox">
            <ul>
                <li><a href="/userhome">HOME</a></li>
                <li><a href="/userabout">ABOUT</a></li>
                <li><a href="/userservices">SERVICES</a></li>
                <li><a href="/userfaqs">FAQS</a></li>
                <li><a href="/userannouncements">ANNOUNCEMENTS</a></li>
            </ul>
            <ul>
                <li>
                    <h6>
                        If you need more information about contacts or have specific questions, please check our
                        <a href="/userfaqs">FAQs</a>.
                        Our Frequently Asked Questions section is designed to provide you with quick and easy access to the
                        most
                        commonly asked questions and detailed answers. Whether you're looking for contact information,
                        seeking assistance, or simply curious about our services, our FAQs are here to help.
                    </h6>
                </li>
            </ul>
            <ul>
                <li>
                    <p>Contact Info:</p>
                </li>
                <li>
                    <p>MDRRMO Morong, Rizal</p>
                </li>
                <li>
                    <p><i class="bi bi-telephone-fill"></i> : 0919-081-7181/(027)212-5741</p>
                </li>
                <li>
                    <p><i class="bi bi-envelope-at-fill"></i> : mdrrmo.morongrizal1@gmail.com</p>
                </li>
            </ul>
        </div>
    </section>
@endsection
