@extends('publiclayout')
@section('public_content')
    <section class="services-context">
        <div class="container-xl">
            <div class="services-ESA-flexbox">
                <div class="services-images">
                    <img src="{{ asset('images/publicpics/alarm.png') }}" alt="">
                </div>
                <div class="services-text">
                    <h2>Emergency Situation Assistance</h2>
                    <p>Immediate support during crises to minimize risks and provide essential care swiftly and efficiently.
                    </p>
                </div>
            </div>
            <div class="services-FAA-flexbox">
                <div class="services-text">
                    <h2>First Aid Administration</h2>
                    <p>Expert first aid services to stabilize and treat injuries on-site, ensuring timely medical
                        intervention.
                    </p>
                </div>
                <div class="services-images">
                    <img src="{{ asset('images/publicpics/first-aid-kit.png') }}" alt="">
                </div>
            </div>
            <div class="services-NMDPA-flexbox">
                <div class="services-images">
                    <img src="{{ asset('images/publicpics/disaster.png') }}" alt="">
                </div>
                <div class="services-text">
                    <h2>Natural and Man-made Disasters Property Assistance</h2>
                    <p>Comprehensive assistance in the aftermath of natural or man-made disasters, helping to protect and
                        recover properties.
                    </p>
                </div>
            </div>
            <div class="services-ERO-flexbox">
                <div class="services-text">
                    <h2>Evacuation and Rescue Operations</h2>
                    <p> Skilled and coordinated evacuation and rescue missions to safeguard lives and ensure swift
                        relocations to safety.
                    </p>
                </div>
                <div class="services-images">
                    <img src="{{ asset('images/publicpics/rescue.png') }}" alt="">
                </div>
            </div>
            <div class="services-ATO-flexbox">
                <div class="services-images">
                    <img src="{{ asset('images/publicpics/ambulance.png') }}" alt="">
                </div>
                <div class="services-text">
                    <h2>Ambulance Transport Operation</h2>
                    <p>Round-the-clock ambulance services for prompt and reliable medical transportation, ensuring
                        continuous care and rapid response.
                    </p>
                </div>
            </div>
            <div class="services-DRRS-flexbox">
                <div class="services-text">
                    <h2>Disaster Risk Reduction Seminars</h2>
                    <p>We are dedicated to enhancing community resilience through regular
                        DRR seminars. These sessions equip individuals and businesses with essential
                        knowledge and skills to effectively respond to and mitigate the impacts of natural and man-made
                        disasters. Join us to learn about emergency planning, safety protocols, and recovery strategies, and
                        help build a safer, more prepared community. Interested? <a href="#">Join</a> with us on our
                        upcoming seminars!
                    </p>
                </div>
                <div class="services-images">
                    <img src="{{ asset('images/publicpics/training.png') }}" alt="">
                </div>
            </div>
            <center class="services-footer-text">
                Our commitment to excellence and readiness makes us a dependable partner during emergencies. Explore our
                full range of services to see how we can assist you in times of need.
            </center>
        </div>
    </section>
@endsection
