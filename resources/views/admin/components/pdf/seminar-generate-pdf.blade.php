<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Seminar - MDRRMO Morong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"
        integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link href="{{ asset('css/pdf-template.css') }}" rel="stylesheet">
</head>

<body>
    <div class="header">
        <div class="logo-1">
            <img src="{{ asset('images/pdf-template-pics/mdrrmc.JPG') }}" alt="">
        </div>
        <div class="company-name">
            <h3>Municipal Disaster Risk Reduction <br> and Management Council</h3>
            <p>Morong, Rizal</p>
        </div>
        <div class="logo-2">
            <img src="{{ asset('images/pdf-template-pics/ndrrmc.png') }}" alt="">
        </div>
    </div>
    <div class="container-xl">
        <h3>Subscriber</h3>
        <div class="table-responsive-lg">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 20%" scope="col-1">Title</th>
                        <th style="width: 40%" scope="col-1">Description</th>
                        <th style="width: 10%" scope="col-1">Location</th>
                        <th style="width: 5%" scope="col-1">Status</th>
                        <th style="width: 15%" scope="col-1">Started at</th>
                        <th style="width: 10%" scope="col-1">Ended/Cancelled</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seminars as $seminar)
                        <tr>
                            <td>{{ $seminar->title }}</td>
                            <td>{{ $seminar->description }}</td>
                            <td>{{ $seminar->location }}</td>
                            <td>{{ $seminar->status }}</td>
                            <td>{{ $seminar->starts_at }}</td>
                            <td>{{ Carbon\Carbon::create($seminar->updated_at)->format('h:i a M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
