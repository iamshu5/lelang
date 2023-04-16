@include('_partials.admin.header', ['title' => 'Data Petugas'])
<section id="table-barang">
    <div class="container-fluid">
        <div class="d-flex">
            <a href="{{ url('/admin/data/admin-petugas') }}"><i class="fas fa-sync-alt"></i> refresh</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-user-shield"></i> Data Petugas</li>
            </ol>
        </nav>
        {{-- <div class="mb-3 d-flex justify-content-end">
            <form class="form-inline d-sm-inline-block">
                <input class="form-control mr-sm-2 btn-sm mx-auto" name="search_petugas" type="search"
                    placeholder="Cari Data Petugas" aria-label="Search" value="{{ request()->search_petugas ?? '' }}">
        <button class="btn btn-outline-primary my-2 my-sm-0 btn-sm" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div> --}}

    {{-- TABLE kontak --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">TABEL DATA PETUGAS</h6>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-info shadow-sm" data-toggle="modal" data-target="#ModalTambah">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            {{-- Alert --}}
            @if (session()->exists('alert'))
            <div class="alert alert-{{ session()->get('alert') ['bg'] }} alert-dismissible fade show" role="alert">
                {{ session()->get('alert') ['message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error )
                {{ $error }}
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($petugas)==0)
                        <tr>
                            <td colspan="5" class="text-center bg-gradient-danger text-white">
                                Tidak ada data.
                            </td>
                        </tr>
                        @endif

                        @foreach ($petugas as $index => $data)
                        <tr>
                            <td>{{ $index + $petugas->firstItem() }}</td>
                            <td>{{ $data->nama_petugas }}</td>
                            <td>{{ $data->username }}</td>
                            <td>*Tidak ditampilkan*</td>
                            <td>{{ $data->levels->level }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm rounded mb-1" data-toggle="modal"
                                    data-target="#editModal{{ $index }}"><i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                <button class="btn btn-danger btn-sm rounded mb-1 deletePetugas"
                                        data-id="{{ $data->id_petugas }}" data-nama="{{ $data->nama_petugas }}"><i
                                    class="fas fa-trash"></i></button>

                                {{-- <button class="btn btn-danger btn-sm rounded mb-1 delete"
                                        onclick="confirmDelete('{{ url('data/admin-petugas/delete/'. $data->id_petugas) }}')"><i
                                    class="fas fa-trash"></i></button> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Total ada {{ $petugas->total() }} Data Petugas
                <div class="d-flex justify-content-end">
                    {{ $petugas->links() }}
                </div> --}}
            </div>
        </div>
    </div>
    </div>
</section> {{-- End Data Tabel --}}

<section id="form-tambah-barang">
    <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Form Tambah Auth</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('admin/data/admin-petugas/tambah/process') }}" enctype="multipart/form-data"
                    method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <label for="">Nama Petugas*</label>
                            <input type="text" class="form-control @error('nama_petugas') is-invalid 
                            @enderror" name="nama_petugas" value="{{ old('nama_petugas') }}"
                                placeholder="Masukan nama petugas">
                            @error('nama_petugas')
                            <div class="invalid-feedback">Masukan Nama Petugas!</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <label for="">Username*</label>
                            <input type="text" class="form-control @error('username') is-invalid 
                            @enderror" name="username" value="{{ old('username') }}" placeholder="Masukan Username">
                            @error('username')
                            <div class="invalid-feedback">Masukan Username Anda!</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <label for="">Password*</label>
                            <input type="password" class="form-control @error('password') is-invalid 
                            @enderror" name="password" value="{{ old('password') }}" placeholder="Masukan Password">
                            @error('password')
                            <div class="invalid-feedback">Masukan Password!</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <label for="">Level Auth*</label>
                            <select name="id_level" id="id_level"
                                class="form-control @error('id_level') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Level Petugas</option>
                                @foreach( $levels as $index => $data )
                                    <option value="{{ $data->id_level }}"> {{ $data->level }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_level')
                            <div class="invalid-feedback">Masukan Level Auth!</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Simpan Data Petugas <i
                                class="fa-solid fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> {{-- End Form Tambah Petugas --}}

{{-- EDIT PETUGAS --}}
@foreach ($petugas as $index => $data)
<div class="modal fade" id="editModal{{ $index }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/admin/data/admin-petugas/edit/' . $data->id_petugas) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-floating mb-3">
                        <label for="">ID Petugas</label>
                        <input type="number" name="id_petugas" class="form-control" value="{{ $data->id_petugas }}"
                            readonly>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Nama Petugsa</label>
                        <input type="text" name="nama_petugas" class="form-control" value="{{ $data->nama_petugas }}"
                            required placeholder="Masukan Nama Petugas">
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $data->username }}" required
                            placeholder="Masukan Username">
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control"
                            placeholder="Masukan password jika ingin diubah">
                    </div>

                    <div class="form-floating mb-3">
                        <select name="id_level" class="form-control" required>
                            <option value="1" {{ $data->levels->level == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="2" {{ $data->levels->level == 'petugas' ? 'selected' : ''}}>Petugas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-check-circle"></i> Simpan
                        Perubahan</button>
                    <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@include('_partials.admin.footer')
<script>
    $('.deletePetugas').click(function () {
        let id = $(this).attr('data-id');
        let nama = $(this).attr('data-nama');
        swal({
                title: "HAPUS DATA PETUGAS?",
                text: "Menghapus <" + nama + "> ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = "/admin/data/admin-petugas/delete/" + id + ""
                    swal("Data Petugas Telah Berhasil Dihapus!", {
                        icon: "success",
                    });
                } else {
                    swal("OK! Gajadi Hapus Data Petugas");
                }
            });
    });
</script>