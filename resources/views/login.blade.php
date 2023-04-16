<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login • Page</title>
    {{-- FAVICON --}}
    <link rel="icon" type="image/x-icon" href="{{ url('assets/image/LELANG.jpg') }}">
    {{-- Kit FontAwesome --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <div class="container pt-5 mt-5">
        <div class="card o-hidden border-0 shadow-lg my-5">
            @if (session()->exists('alert'))
                    <div class="alert alert-{{ session()->get('alert') ['bg'] }} alert-dismissible fade show" role="alert">
                        {{ session()->get('alert') ['message'] }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endif
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="p-1">
                            <div class="text-center">
                                <h4 class="h4 text-dark-800 mb-4">Login</h4>
                                <h6 class="h6 text-gray-900 mb-4">Welcome Back!</h6>
                            </div>
                            <form method="POST" class="user">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user"
                                        placeholder="Username..." name="username" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                         placeholder="Password..." name="password" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary btn-user shadow-sm" 
                                    type="submit" name="login">Login</button>
                                </div>
                            </form>
                            <hr>
                            {{-- <div class="text-center">
                                <a class="small btn btn-secondary" href="{{ url('register') }}">Create an account? Register!</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>