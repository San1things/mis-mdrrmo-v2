<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Users - MRRMO Morong</title>
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
        <h3>USER</h3>
        <div class="table-responsive-lg">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col-1">First Name</th>
                        <th scope="col-1">Last Name</th>
                        <th scope="col-1">Email</th>
                        <th scope="col-1">Usertype</th>
                        <th scope="col-1">Username</th>
                        <th scope="col-1">Gender</th>
                        <th scope="col-1">Birthday</th>
                        <th scope="col-1">Contact #</th>
                        <th scope="col-1">Team</th>
                        <th scope="col-1">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->usertype }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->bday }}</td>
                            <td>0{{ $user->contact }}</td>
                            <td>{{ $user->team }}</td>
                            <td>{{ Carbon\Carbon::create($user->created_at)->format('h:i a M d, Y')  }}</td>
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
