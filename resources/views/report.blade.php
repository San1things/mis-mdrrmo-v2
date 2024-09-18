@extends('publiclayout')
@section('public_content')
    <div class="container-xl">
        <section class="report-title">
            <center>
                <h3>Report</h3>
                <h6>You can report to us in time of disaster, accident or any type of incident.</h6>
            </center>
        </section>

        @isset($alert)
            <center>
                <div class="alert alert-dismissible fade show fs-3 alert-{{ !empty($alerts[$alert]) ? $alerts[$alert][1] : '' }}"
                    role="alert">
                    {{ !empty($alerts[$alert]) ? $alerts[$alert][0] : 'error' }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                </div>
            </center>
        @endisset

        <section class="report-container">
            <form action="/publicreportprocess" method="POST">
                @csrf
                <div class="report-inputs">
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Name:</label>
                        <input class="form-control fs-3" name="name" type="text" placeholder="Name* (IMPORTANT)"
                            required></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Contact:</label>
                        <input class="form-control fs-3" name="contact" type="number"
                            placeholder="Contact Number* (IMPORTANT)" required></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">Barangay:</label>
                        <select class="form-select fs-3" name="barangay" aria-label="Default select example" required>
                            <option value="" hidden>Select Barangay...</option>
                            <option value="San Juan">San Juan</option>
                            <option value="Calero-Caniogan-Lanang">Calero-Caniogan-Lanang</option>
                            <option value="Lagundi">Lagundi</option>
                            <option value="Maybancal">Maybancal</option>
                            <option value="San Guillermo">San Guillermo</option>
                            <option value="San Jose">San Jose</option>
                            <option value="San Pedro">San Pedro</option>
                            <option value="Bombongan">Bombongan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-5" for="floatingInput">What is happening?</label>
                        <textarea class="form-control fs-3" name="description" type="text" placeholder="Description..." required></textarea>
                    </div>
                    <div class="mb-3" style="display: none">
                        <input class="form-control fs-3" id="latitude" name="latitude" type="text" readonly></input>
                        <input class="form-control fs-3" id="longitude" name="longitude" type="text" readonly></input>
                    </div>
                </div>

                <div class="mb-3 report-map">
                    <label class="form-label fs-5">Pinpoint your location:</label>
                    <div id="map" style="height: 400px; width: 100%; z-index: 1;cursor: auto !important;"></div>
                    <button class="btn btn-secondary fs-3 report-undo-btn" id="undo" type="button"
                        style="display:none">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
                <center>
                    <div class="form-check report-checkbox">
                        <input class="form-check-input fs-3" id="signeddisclaimer" name="signeddisclaimer" type="checkbox"
                            required>
                        <label class="form-check-label fs-4" for="flexCheckDefault">
                            <strong>Disclaimer:</strong> Setting up fake pranks and peddling fake news could be charged for
                            violating Republic Act 10175
                            (Anti-Cybercrime Law), or under Section 6 (f) of Republic Act 11469 (Bayanihan to Heal As One
                            Act), whichever is applicable.
                        </label>
                    </div>
                    <button class="btn btn-dark report-submit-btn" type="submit">Submit</button>
                </center>
            </form>
        </section>
    </div>
@endsection

@push('public_scripts')
    <script>
        $(document).ready(function() {
            //MAP DEFAULT VIEW
            let map = L.map('map').setView([14.514859, 121.239068], 15);
            var marker;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // MAP FUNCTION
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng]).addTo(map);

                $('#latitude').val(lat);
                $('#longitude').val(lng);
                $('#undo').attr('style', '');
            });

            $('#undo').on('click', function() {
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }

                $('#latitude').val('');
                $('#longitude').val('');
                $('#undo').attr('style', 'display:none');
            });

            // Add a marker at the specified coordinates
            // var marker = L.marker([14.506752, 121.237364]).addTo(map)
            //     .bindPopup('Your pinpoint location')
            //     .openPopup();
        });
    </script>
@endpush
