@extends('user.components.userlayout')
@section('resident_content')
    <section class="faqs-content">
        <div class="container-xl">
            <div class="faqs-intro">
                <center>
                    <h2>Do You Have Questions?</h2>
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
                    <p><i class="bi bi-pin-fill"></i> Log in and <a href="/userseminars">join</a> our seminar to reserve your
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
        </div>
    </section>

    <section>
        <div class="faqs-additional-question">
            <div class="container-xl">
                <center>
                    <h4>If you stil dont have your answer, you can ask us here!</h4>

                    <form action="" method="">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" name="faqsquestionname" type="text" value="{{ $user->firstname }} {{ $user->lastname }}"
                                aria-label="Name" placeholder="Name" required="required" readonly>
                            <input class="form-control" name="faqsquestionemail" type="email"
                                value=" {{ $user->email }} " aria-label="Email" placeholder="Email" required="required"
                                readonly>
                        </div>
                        <textarea class="form-control" id="" name="" rows="3" placeholder="Ask your question here..."
                            required="required"></textarea>
                        <button class="btn btn-primary" type="submit">Send</button>
                    </form>
                    <p>Note: It is important to put your real email at the top because we're gonna send our answers there.
                    </p>
                </center>
            </div>
        </div>
    </section>
@endsection
