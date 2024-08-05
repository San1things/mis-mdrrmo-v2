@extends('publiclayout')
@section('public_content')
    <section class="faqs-content">
        <div class="container-xl wrapper">
            <div class="faqs-intro">
                <center>
                    <h3>Do You Have Questions?</h3>
                    <h6>We have your answers</h6>
                    <p>Below you have the answer to all your questions and concerns. Our comprehensive FAQ section is
                        designed to provide you with quick and easy access to the information you need. Whether you’re
                        seeking details about our services, looking for contact information, or curious about how we
                        operate, you will find the answers right here. Dive in to learn more and get the clarity you need.
                    </p>
                    <img src="{{ asset('images/publicpics/confusion.png') }}" alt="">
                </center>
            </div>
            <div class="faqs-questions" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false"
                aria-controls="collapseExample">
                <h6>What are the emergency hotlines in Morong, Rizal?</h6>
            </div>
            <div class="collapse" id="collapseExample1">
                <div class="faqs-collapse">
                    <center>
                        <img src="{{ asset('images/publicpics/mdrrmopic1.jpg') }}" alt="">
                    </center>
                </div>
            </div>
            <div class="faqs-questions" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false"
                aria-controls="collapseExample">
                <h6>What are the services offer?</h6>
            </div>
            <div class="collapse" id="collapseExample2">
                <div class="faqs-collapse">
                    <p><i class="bi bi-pin-fill"></i> Kindly check our <a href="/services">services</a> page to check our
                        services.</p>
                </div>
            </div>
            <div class="faqs-questions" data-bs-toggle="collapse" data-bs-target="#collapseExample3" aria-expanded="false"
                aria-controls="collapseExample">
                <h6>How to join on our seminar?</h6>
            </div>
            <div class="collapse" id="collapseExample3">
                <div class="faqs-collapse">
                    <p><i class="bi bi-pin-fill"></i> Log in and <a href="#">join</a> our seminar to reserve your
                        slots and seats.</p>
                </div>
            </div>
            <div class="faqs-questions" data-bs-toggle="collapse" data-bs-target="#collapseExample4" aria-expanded="false"
                aria-controls="collapseExample">
                <h6>Where can you locate us?</h6>
            </div>
            <div class="collapse" id="collapseExample4">
                <div class="faqs-collapse">
                    <p><i class="bi bi-pin-fill"></i> We are located inside the Morong Public Market.</p>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1198.8744253632572!2d121.23568136833325!3d14.506745562764063!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c154d20276a7%3A0xc07199090e00413!2sMDRRMO%20Morong!5e1!3m2!1sen!2sph!4v1722870161978!5m2!1sen!2sph"
                        style="border:0;" width="100%" height="400vh" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div class="faqs-questions" data-bs-toggle="collapse" data-bs-target="#collapseExample5" aria-expanded="false"
                aria-controls="collapseExample">
                <h6>What time are the working hours of the Org?</h6>
            </div>
            <div class="collapse" id="collapseExample5">
                <div class="faqs-collapse">
                    <p><i class="bi bi-pin-fill"></i> The building is open from 8:00am in the morning to 5:00pm in the
                        afternoon. Monday to Saturday.</p>
                </div>
            </div>
            <div class="faqs-questions" data-bs-toggle="collapse" data-bs-target="#collapseExample6" aria-expanded="false"
                aria-controls="collapseExample">
                <h6>What are the dates of the seminars?</h6>
            </div>
            <div class="collapse" id="collapseExample6">
                <div class="faqs-collapse">
                    <p><i class="bi bi-pin-fill"></i> It depends, you can subscribe us to get an email for real-time updates
                        from our org.</p>
                    <div class="input-group faqs-collapse-subscribe">
                        <input class="form-control" type="email" aria-label="Email"
                            aria-describedby="button-addon2" placeholder="Email" required="required">
                        <button class="btn btn-outline-primary" id="button-addon2" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
