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
                        <th style="width: 5%" scope="col">User ID</th>
                        <th style="width: 5%" scope="col">Usertype</th>
                        <th style="width: 15%" scope="col">Name</th>
                        <th style="width: 15%" scope="col">Action</th>
                        <th style="width: 50%" scope="col">Description</th>
                        <th style="width: 10%" scope="col">DateTime</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->user_id }}</td>
                            <td>{{ $log->usertype }}</td>
                            <td>{{ $log->firstname }} {{ $log->lastname }}</td>
                            <td>{{ $log->log_title }}</td>
                            <td>{{ $log->log_description }}</td>
                            <td>{{ Carbon\Carbon::create($log->log_created_at)->format('D - M d, Y h:i a') }}</td>
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
