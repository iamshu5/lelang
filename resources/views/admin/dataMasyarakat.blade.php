@include('_partials.admin.header', ['title' => 'Data Masyarakat'])
<section id="table-masyarakat">
    <div class="container-fluid">
        <div class="d-flex">
            <a href="{{ url('/admin/data/masyarakat') }}"><i class="fas fa-sync-alt"></i> refresh</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-users"></i> Data Masyarakat</li>
            </ol>
        </nav>
        {{-- <div class="mb-3 d-flex justify-content-end">
            <form class="form-inline d-sm-inline-block">
                <input class="form-control mr-sm-2 btn-sm mx-auto" name="search_masyarakat" type="search"
                    placeholder="Cari Data Masyarakat" aria-label="Search"
                    value="{{ request()->search_masyarakat ?? '' }}">
                <button class="btn btn-outline-primary my-2 my-sm-0 btn-sm" type="submit"><i
                        class="fas fa-search"></i></button>
            </form>
        </div>  --}}

        {{-- TABLE --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">TABEL DATA MASYARAKAT</h6>
                <div class="d-flex justify-content-end">
                    {{-- <button type="button" class="btn btn-info shadow-sm" data-toggle="modal" data-target="#ModalTambah">
                        <i class="fa-solid fa-plus"></i>
                    </button> --}}
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
                                <th>Nama Masyarakat</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Telp</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($masyarakat)==0)
                            <tr>
                                <td colspan="6" class="text-center bg-gradient-danger text-white">
                                    Tidak ada data.
                                </td>
                            </tr>
                            @endif

                            @foreach ($masyarakat as $index => $data)
                            <tr>
                                <td>{{ $index + $masyarakat->firstItem() }}</td>
                                <td>{{ $data->nama_masyarakat }}</td>
                                <td>{{ $data->username }}</td>
                                <td>*Tidak ditampilkan*</td>
                                <td>{{ $data->telp }}</td>
                                <td>
                                    {{-- <button class="btn btn-warning btn-sm rounded mb-1" data-toggle="modal"
                                        data-target="#editModal{{ $index }}"><i
                                            class="fa-solid fa-pen-to-square"></i></button> --}}
                                    <button class="btn btn-danger btn-sm rounded mb-1 deleteMasyarakat"
                                        data-id="{{ $data->id_masyarakat }}" data-nama="{{ $data->nama_masyarakat }}"><i
                                        class="fas fa-trash"></i></button>
                                    {{-- <button class="btn btn-danger btn-sm rounded mb-1 delete"
                                        onclick="confirmDelete('{{ url('data/masyarakat/delete/'. $data->id_masyarakat) }}')"><i
                                            class="fas fa-trash"></i></button> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Total ada {{ $masyarakat->total() }} Data Masyarakat
                    <div class="d-flex justify-content-end">
                        {{ $masyarakat->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section> {{-- End Data Tabel Masyarakat --}}

<section id="form-tambah-masyarakat">
    <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Form Tambah Masyarakat</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('admin/data/masyarakat/tambah/process') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <label for="">Nama Masyarakat*</label>
                            <input type="text" class="form-control @error('nama_masyarakat') is-invalid 
                            @enderror" name="nama_masyarakat" value="{{ old('nama_masyarakat') }}"
                                placeholder="Masukan nama masyarakat">
                            @error('nama_masyarakat')
                            <div class="invalid-feedback">Masukan Nama Masyarakat!</div>
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
                            <label for="">No. Telepon*</label>
                            <input type="number" min="0" name="telp"
                                class="form-control @error('telp') is-invalid @enderror" placeholder="08xxxx">
                                @error('telp')
                                    <div class="invalid-feedback">Masukan Nomor Telepon!</div>
                                @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Simpan Data Masyarakat <i
                                class="fa-solid fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> {{-- End Form Tambah Masyarakat --}}


{{-- EDIT --}}
@foreach ($masyarakat as $index => $data)
<div class="modal fade" id="editModal{{ $index }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Edit Masyarakat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/admin/data/masyarakat/edit/' . $data->id_masyarakat) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-floating mb-3">
                        <label for="">ID masyarakat</label>
                        <input type="number" name="id_masyarakat" class="form-control" value="{{ $data->id_masyarakat }}"
                            readonly>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Nama Masyarakat</label>
                        <input type="text" name="nama_masyarakat" class="form-control" value="{{ $data->nama_masyarakat }}"
                            required placeholder="Masukan Nama masyarakat">
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $data->username }}" required
                            placeholder="Masukan Username">
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control" placeholder="Masukan Password">
                    </div>

                    <div class="form-floating mb-3">
                        <label for="">Telepon</label>
                        <input type="number" min="0" name="telp" class="form-control" placeholder="08xxx" value="{{ $data->telp }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-check-circle"></i> Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@include('_partials.admin.footer')

<script>
    // DELETE MASYARAKAT
    $('.deleteMasyarakat').click(function () {
        let id = $(this).attr('data-id');
        let nama = $(this).attr('data-nama');
        swal({
                title: "HAPUS DATA MASYARAKAT?",
                text: "WARNING! Menghapus data -" + nama + "- mengakibatkan pengguna tidak bisa login kembali!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "/admin/data/masyarakat/delete/" + id + ""
                    swal("Data Masyarakat Telah Berhasil Dihapus!", {
                        icon: "success",
                    });
                } else {
                    swal("OK! Gajadi Hapus Data Masyarakat");
                }
            });
    });
</script>