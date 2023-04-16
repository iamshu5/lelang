@php $user = Illuminate\Support\Facades\Auth::user(); @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} • {{ Str::upper($user->levels->level) }}</title>
    {{-- FAVICON --}}
    <link rel="icon" type="image/x-icon" href="{{ url('assets/admin/image/LELANG.jpg') }}">
    {{-- Kit FontAwesome --}}
    <link rel="stylesheet" href="{{ url('assets/admin/js/7fdd60d3a4.js') }}">
    <link href="{{ url('assets/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- CSS Sb Admin-->
    <link href="{{ url('assets/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        {{-- SIDEBAR  --}}
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ url($user->levels->level . '/dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ url('assets/admin/image/LELANG.jpg') }}" width="70" height="" class="rounded"
                        alt="">
                    <br>
                </div>
                <div class="sidebar-brand-text mx-3 mt-2">Sistem Pelelangan, {{ $user->levels->level }}</div>
            </a>
            <hr class="sidebar-divider my-0 mt-2">
            {{-- Nav Item --}}
            <li class="nav-item {{ $title === 'Dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ url($user->levels->level . '/dashboard') }}">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Dashboard</span></a>
            </li>

            @include('_partials.sidebar.' . $user->levels->level)

            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="dropdown-item text-white bg-transparant mb-5 mt-2" data-toggle="modal"
                    data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-300"></i>
                    Logout
                </a>
            </li>
            {{-- TOMBOL SIDEBAR --}}
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul><!-- End Tombol Sidebar -->
        {{-- Logout Modal --}}
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Logout!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">Yakin {{ auth()->user()->nama_petugas }} ingin Logout?</div>
                    {{-- {{ auth()->user()->nama_petugas }} --}}
                    <div class="modal-footer">
                        <a class="btn btn-primary" href="{{ url('/logout') }}">Logout aja</a>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Gajadi deh</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">
                    {{-- TOMBOL SIDEBAR MOBILE --}}
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="ml-md-3 font-italic" id="clock-realtime"><?= date('Y-m-d H:i:s') ?> </span>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><i
                                    class="fa-solid fa-user-shield"></i> {{ auth()->user()->nama_petugas }} !
                            </span>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->