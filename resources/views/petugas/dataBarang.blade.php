@include('_partials.admin.header', ['title' => 'Data Barang'])
<section id="table-barang">
    <div class="container-fluid">
        <div class="d-flex">
            <a href="{{ url('/petugas/data/barang') }}"><i class="fas fa-sync-alt"></i> refresh</a>
        </div>

        <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#importBarang">
            <i class="fas fa-file-excel"></i> Import Excel Barang
        </button>
        <!-- Modal -->
        <div class="modal fade" id="importBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/importbarang') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Import Barang</label>
                                <input type="file" name="importbarang" class="form-control-file">
                            </div>
                            @error('importbarang')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/petugas/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-boxes-packing"></i> Data
                    Barang</li>
            </ol>
        </nav>
        {{-- <div class="mb-3 d-flex justify-content-end">
            <form class="form-inline d-sm-inline-block">
                <input class="form-control mr-sm-2 btn-sm mx-auto" name="search_barang" type="search"
                    placeholder="Cari Data Barang" aria-label="Search" value="{{ request()->search_barang ?? '' }}">
            <button class="btn btn-outline-primary my-2 my-sm-0 btn-sm" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div> --}}
        {{-- TABLE kontak --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 bg-info">
                <h6 class="m-0 font-weight-bold text-white">TABEL DATA BARANG</h6>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-info shadow-sm" data-toggle="modal"
                        data-target="#ModalTambah">
                        <i class="fa-solid fa-plus"></i> Tambah Barang
                    </button>
                </div>
            </div>

            <div class="card-body">
                {{-- Alert --}}
                @if (session()->exists('alert'))
                    <div class="alert alert-{{ session()->get('alert')['bg'] }} alert-dismissible fade show"
                        role="alert">
                        {{ session()->get('alert')['message'] }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
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
                                <th>Foto Barang</th>
                                <th>Nama Barang</th>
                                <th>Tanggal dibuat</th>
                                <th>Harga Awal</th>
                                <th>Deskripsi Barang</th>
                                <th>Stok Barang</th>
                                <th>Status</th>
                                <th>Pemenang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if (count($barang) == 0)
                                <tr>
                                    <td colspan="10" class="text-center bg-gradient-danger text-white">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endif --}}

                            @foreach ($barang as $index => $data)
                                <tr>
                                    <td>{{ $index + $barang->firstItem() }}</td>
                                    <td>
                                        <img height="80"
                                            src="{{ url("assets/admin/image/barang/{$data->foto_barang}") }}"
                                            alt="Foto Barang" class="rounded" id="imgPreview">
                                    </td>
                                    <td>{{ $data->nama_barang }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y - H:i') }} WIB</td>
                                    <td>Rp. {{ number_format($data->harga_awal), 0, ',', '.', '' }}</td>
                                    <td>{{ $data->deskripsi_barang }}</td>
                                    <td>{{ $data->stok }}</td>
                                    <td>- {{ $data->tb_lelang->status ?? '' }}</td>
                                    <td>-
                                        {{ is_object($data->tb_lelang) && $data->tb_lelang->masyarakat ? $data->tb_lelang->masyarakat->nama_masyarakat : '' }}
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm rounded mb-1" data-toggle="modal"
                                            data-target="#editModal{{ $index }}"><i
                                                class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-danger btn-sm rounded mb-1 deleteBarang"
                                            data-id-barang="{{ $data->id_barang }}"
                                            data-nama="{{ $data->nama_barang }}"><i class="fas fa-trash"></i></button>
                                        {{-- <button class="btn btn-danger btn-sm rounded mb-1 delete"
                                        onclick="confirmDelete('{{ url('barang/delete/'. $data->id_barang) }}')"><i
                                    class="fas fa-trash"></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section> {{-- End Data Tabel Barang --}}


<section id="form-tambah-barang">
    <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Form Tambah Barang</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('petugas/barang/tambah/process') }}" enctype="multipart/form-data"
                    method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload" src="" alt=""
                                style="max-height: 300px;">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Foto Barang*</label>
                            <input type="file"
                                class="form-control-file @error('foto_barang') is-invalid 
                            @enderror"
                                name="foto_barang" id="foto_barang" value="{{ old('foto_barang') }}"
                                placeholder="Masukan foto barang">
                            @error('foto_barang')
                                <div class="invalid-feedback">Terjadi Kesalahan: {{ $message }}!</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Nama Barang*</label>
                            <input type="text"
                                class="form-control @error('nama_barang') is-invalid 
                            @enderror"
                                name="nama_barang" value="{{ old('nama_barang') }}"
                                placeholder="Masukan nama barang">
                            @error('nama_barang')
                                <div class="invalid-feedback">Masukan Nama Barang!</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Tanggal Barang Di Upload*</label>
                            <input type="datetime-local" id="tanggal"
                                class="form-control @error('tanggal') is-invalid 
                            @enderror"
                                name="tanggal" value="{{ old('tanggal') }}" placeholder="Masukan tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">Input Tanggal!</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Harga Awal*</label>
                            <input type="number" min="0"
                                class="form-control @error('harga_awal') is-invalid 
                            @enderror"
                                name="harga_awal" value="{{ old('harga_awal') }}"
                                placeholder="Masukan harga awal barang">
                            @error('harga_awal')
                                <div class="invalid-feedback">Input Harga Awal!</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Deskripsi Barang*</label>
                            <textarea name="deskripsi_barang" cols="30" rows="10"
                                class="form-control @error('deskripsi_barang') is-invalid @enderror" placeholder="Masukan deskripsi barang">{{ old('deskripsi_barang') }}</textarea>
                            @error('deskripsi_barang')
                                <div class="invalid-feedback">Input Deskripsi Barang!</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Stok Barang*</label>
                            <input type="number" name="stok" min="0"
                                class="form-control @error('stok') is-invalid @enderror"
                                placeholder="Masukan Stok Barang" value="{{ old('stok') }}">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Simpan Data Barang <i
                                class="fa-solid fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> {{-- End Form TAmbah Barang --}}

{{-- EDIT BARANG --}}
@foreach ($barang as $index => $data)
    <div class="modal fade" id="editModal{{ $index }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/petugas/barang/edit/' . $data->id_barang) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-floating mb-3">
                            <label for="">ID Barang</label>
                            <input type="number" name="id_barang" class="form-control"
                                value="{{ $data->id_barang }}" readonly>
                        </div>
                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload-2" class="rounded shadow" src=""
                                alt="" style="max-height: 150px;">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Foto Barang</label>
                            <input type="file" name="foto_barang" class="form-control" id="foto_barang-2"
                                value="{{ $data->foto_barang }}" placeholder="Masukan Foto Barang">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="{{ $data->nama_barang }}" required placeholder="Masukan Nama Barang">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Tanggal</label>
                            <input type="datetime-local" name="tanggal" id="datepicker" class="form-control"
                                value="{{ $data->tanggal }}" required placeholder="Masukan Tanggal">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Harga Awal</label>
                            <input type="text" min="0" name="harga_awal" class="form-control"
                                value="{{ $data->harga_awal }}" required placeholder="0">
                            {{-- <span class="text-warning">Max: 2.000.000.000</span> --}}
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Deskripsi Barang</label>
                            <textarea name="deskripsi_barang" class="form-control" cols="30" rows="10" required>{{ $data->deskripsi_barang }}</textarea>
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Stok Barang</label>
                            <input name="stok" class="form-control" min="0" required
                                value="{{ $data->stok }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-check-circle"></i>
                            Simpan
                            Perubahan</button>
                        <button type="button" class="btn btn-secondary shadow-sm"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@include('_partials.admin.footer')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script src="https://datatables.net/extensions/buttons/examples/html5/columns.html"></script>

<script>
    $(document).ready(function() {
        let table = $('#dataTable').DataTable({
            buttons: [ 'pdf', 'excel', 'copy', 'csv', 'print' ],
            dom: 
                "<'row'<'col-md-2'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "ALL"]
            ]
        });
        table.buttons().container()
            .appendTo('#dataTable_wrapper .col-md-5:eq(0)');
    });

    // DELETE BARANG
    $('.deleteBarang').click(function() {
        let id = $(this).attr('data-id-barang');
        let nama = $(this).attr('data-nama');
        swal({
                title: "HAPUS DATA BARANG?",
                text: "Menghapus Data Barang < " + nama + " > ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = "/petugas/barang/delete/" + id + ""
                    swal("Data Barang Telah Berhasil Dihapus!", {
                        icon: "success",
                    });
                } else {
                    swal("OK! Gajadi Hapus Data Barang");
                }
            });
    });
</script>
