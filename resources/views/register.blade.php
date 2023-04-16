<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register • Page</title>
    {{-- FAVICON --}}
    <link rel="icon" type="image/x-icon" href="{{ url('assets/image/') }}">
    {{-- Kit FontAwesome --}}
    <link rel="stylesheet" href="{{ url('assets/js/7fdd60d3a4.js') }}">
    <link href="{{ url('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- CSS Sb Admin-->
    <link href="{{ url('assets/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>
<body>
    <div class="container pt-5 mt-5">
        <h2 class="h2 text-gray-900 mb-2 text-center">Register</h2>
        <div class="card o-hidden border-0 shadow-lg my-5">
            @if (session()->exists('alert'))
                    <div class="alert alert-{{ session()->get('alert') ['bg'] }} alert-dismissible fade show" role="alert">
                        {{ session()->get('alert') ['message'] }}
                        <button type="button" class="close" aria-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endif
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="{{ url('assets/admin/image/LELANGG.jpg') }}" alt="Foto lelang" width="900px" height="auto">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            {{-- FORM INPUT --}}
                            <form class="user" action="{{ url('register/tambah/process') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user @error('nama_masyarakat')
                                            is-invalid
                                        @enderror"
                                            placeholder="First Name" name="nama_masyarakat" value="{{ old('nama_masyarakat') }}">
                                        @error('nama_masyarakat')
                                            <strong  class="invalid-feedback">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user @error('username')
                                    is-invalid
                                @enderror"
                                        placeholder="Username..." name="username" value="{{ old('username') }}">
                                        @error('username')
                                            <strong  class="invalid-feedback">{{ $message }}</strong>
                                        @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user @error('password')
                                            is-invalid
                                        @enderror"
                                         placeholder="Password" name="password">
                                         @error('password')
                                            <strong  class="invalid-feedback">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="number" min="0" class="form-control form-control-user @error('telp')
                                            is-invalid
                                        @enderror"
                                         placeholder="08xxx" name="telp" value="{{ old('telp') }}">
                                         @error('telp')
                                             <strong  class="invalid-feedback">{{ $message }}</strong>
                                         @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary" type="submit">Register Account</button>
                                </div>
                            </form>
                            <hr>
                            {{-- JIKA SUDAH PUNYA AKUN, KE HALAMAN LOGIN --}}
                            <div class="text-center bg-gradient-info rounded">
                                <a class="small text-white" href="{{ url('masyarakat/login') }}">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>