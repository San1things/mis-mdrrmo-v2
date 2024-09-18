@extends('admin.components.adminlayout')
@section('content')
    @php
        DB::table('tbl_reports')->update([
            'seen' => 1,
        ]);
    @endphp

    <div class="container-xl">

        <div class="admin-header d-flex align-items-center mb-3 border-bottom border-dark" style="position: relative">
            <div class="header-title p-2 flex-grow-1">
                <h3>Reports</h3>
                <p>All the sent reports are all here.({{ $reportsCount }})</p>
            </div>
            <div class="header-export">
            </div>
        </div>

        <div class="admin-report-map">
            <div class="border border-dark" id="map"
                style="height: 50vh; width: 100%; z-index: 1;cursor: auto !important;"></div>
        </div>

        <div class="admin-content">
            <div class="table-responsive-lg fs-4" style="min-height: 25vh; max-height: 25vh; overflow-y:scroll;">
                <table class="table table table-light table-hover mt-3 align-middle">
                    <thead style="position: sticky; top: 0;">
                        <tr>
                            <th style="width: 8%">Reported at</th>
                            <th style="width: 15%">Name</th>
                            <th style="width: 42%">Description</th>
                            <th style="width: 15%">Contact</th>
                            <th style="width: 10%">Barangay</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="{{ $report->handled == 1 ? 'table-success' : '' }}">
                                <td>{{ Carbon\Carbon::create($report->created_at)->format('D, h:ia  M d, Y') }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->contact }}</td>
                                <td>{{ $report->barangay }}</td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $reports->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            //MAP DEFAULT VIEW
            let map = L.map('map').setView([14.514859, 121.239068], 15);
            var marker;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            @php
                $mapreports = DB::table('tbl_reports')->where('handled', 0)->get()->toArray();
            @endphp
            @foreach ($mapreports as $mapreport)
                var marker = L.marker([{{ $mapreport->latitude }}, {{ $mapreport->longitude }}]).addTo(map)
                    .bindPopup("{{ $mapreport->name }} - {{ $mapreport->contact }}")
            @endforeach

        });
    </script>
@endpush
