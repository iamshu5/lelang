@include('_partials.admin.header', ['title' => 'Data Lelang'])
<section id="table-lelang">
    <div class="container-fluid">
        <div class="d-flex">
            <a href="{{ url('/petugas/data/lelang') }}"><i class="fas fa-sync-alt"></i> refresh</a>
        </div>
        <div class="row justify-content-end mr-2">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#CariRiwayat">
                Cari Riwayat
            </button>
            <!-- Modal -->
            <div class="modal fade" id="CariRiwayat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="GET">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Form Cari</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <label for="">Tanggal Mulai</label>
                                        <input type="date" name="tanggal_lelang" id="tanggal_lelang" class="form-control">
                                    </div>
                                    <div class="form-floating mb-3">
                                        <label for="">Tanggal Selesai</label>
                                        <input type="date" name="tanggal_lelang_selesai" id="tanggal_lelang_selesai"  class="form-control">
                                    </div>
                                    <div class="form-floating mb-3">
                                        <label for="">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="" selected disabled>-Pilih Status-</option>
                                            <option value="Dibuka" class="text-success">Dibuka</option>
                                            <option value="Ditutup" class="text-danger">Ditutup</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- <a href="{{ url('exportpdf') }}" class="btn btn-sm btn-primary mb-2"><i class="fas fa-file-pdf"></i> PRINT PDF</a>
        <a href="{{ url('exportexcel') }}" class="btn btn-sm btn-success mb-2"><i class="fas fa-file-excel"></i> PRINT EXCEL</a> --}}
        <!-- Button trigger modal -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i
                        class="fa-solid fa-magnifying-glass-dollar"></i> Data Lelang</li>
            </ol>
        </nav>
        {{-- Alert --}}
        @if (session()->exists('alert'))
            <div class="alert alert-{{ session()->get('alert')['bg'] }} alert-dismissible fade show" role="alert">
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

        {{-- TABLE --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3 bg-info text-white">
                <h6 class="m-0 font-weight-bold">TABEL DATA LELANG</h6>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn text-white shadow-sm" data-toggle="modal"
                        data-target="#ModalTambah">
                        <i class="fa-solid fa-plus"></i> Tambah Pelelangan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID - Nama Barang</th>
                                <th>Tanggal Lelang Mulai</th>
                                <th>Tanggal Lelang Selesai</th>
                                <th>Harga Awal</th>
                                <th>Harga Akhir</th>
                                <th>Winner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if (count($lelang) == 0)
                                <tr>
                                    <td colspan="10" class="text-center bg-gradient-danger text-white">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endif --}}
                            
                            @php $no=1; @endphp
                            @foreach ($lelang as $index => $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->barang->id_barang }} - {{ Str::upper($data->barang->nama_barang) }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_lelang)->format('d/m/Y - H:i') }} WIB
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_lelang_selesai)->format('d/m/Y - H:i') }}
                                        WIB
                                    </td>
                                    <td>Rp. {{ number_format($data->barang->harga_awal) }}</td>
                                    <td>Rp. {{ number_format($data->harga_akhir) }}</td>
                                    <td>{{ is_object($data->masyarakat) ? $data->masyarakat->nama_masyarakat : '' }}
                                    </td> {{-- WINNER --}}
                                    <td class="text-dark">{{ Str::upper($data->status) }}</td>
                                    <td>
                                        {{-- Jika STATUS DITUTUP belum ada pemenang, maka masih bisa DIBUKA KEMBALI lelang nya --}}
                                        @if ($data->status == 'Ditutup' && is_null($data->id_masyarakat))
                                            <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalBuka" >
                                                 <i class="fas fa-check-square"></i> Buka Penawaran
                                            </button>
                                            <div class="modal fade" id="modalBuka" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="exampleModalLabel">BUKA PENAWARAN</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5 class="font-weight-bold">APAKAH INGIN MEMBUKA PENAWARAN</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <a href="{{ url('petugas/data/lelang/edit-status/dibuka/' . $data->id_lelang) }}" class="btn btn-success">Buka Penawaran</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- STATUS SELESAI Akan muncul jika sudah ada salah satu penawar  --}}
                                        @elseif($data->status == 'Dibuka' && $data->history_lelang->count() > 0) 
                                            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modalBuka" >
                                                <i class="fa-solid fa-check-to-slot"></i> Selesai
                                           </button>
                                           <!-- Modal -->
                                           <div class="modal fade" id="modalBuka" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                               <div class="modal-dialog modal-dialog-centered">
                                                   <div class="modal-content">
                                                       <div class="modal-header bg-primary text-white">
                                                       <h5 class="modal-title" id="exampleModalLabel">SELESAI</h5>
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                       </button>
                                                       </div>
                                                       <div class="modal-body">
                                                           <h5 class="font-weight-bold">APAKAH INGIN MENYELESAIKAN LELANG</h5>
                                                       </div>
                                                       <div class="modal-footer">
                                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                       <a href="{{ url('petugas/data/lelang/edit-status/ditutup/' . $data->id_lelang) }}" class="btn btn-primary"><i class="fa-solid fa-check-to-slot"></i> SELESAI</a>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                        @endif
                                        {{-- Jika milih Status dibuka masih bisa edit tanggal --}}
                                        @if ($data->status == 'Dibuka')
                                            <button class="btn btn-warning btn-sm rounded mb-1" data-toggle="modal"
                                                data-target="#editModal{{ $index }}"><i
                                                    class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        @endif
                                        @if ($data->status == 'Ditutup')
                                        <button class="btn btn-outline-danger btn-sm rounded mb-1 deleteLelang"
                                            data-id="{{ $data->id_lelang }}"
                                            data-nama="{{ $data->barang->nama_barang }}"><i class="fas fa-trash"></i> Hapus Lelang
                                        </button>
                                        @endif
                                        {{-- <button class="btn btn-danger btn-sm rounded mb-1 delete"
                                        onclick="confirmDelete('{{ url('data/lelang/delete/'. $data->id_lelang) }}')"><i
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
</section> {{-- End Data Tabel lelang --}}


<section id="form-tambah">
    <div class="modal fade" id="ModalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Form Tambah Lelang</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('petugas/data/lelang/tambah/process') }}" enctype="multipart/form-data"
                    method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <label for="">Nama Barang</label>
                            <select name="id_barang"
                                class="form-control @error('id_barang')
                                is-invalid
                            @enderror">
                                <option value="" selected disabled>Pilih Barang</option>
                                @foreach ($barang as $data)
                                        <option value="{{ $data->id_barang }}"> {{ $data->nama_barang }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Tanggal Lelang*</label>
                            <input type="datetime-local" name="tanggal_lelang"
                                class="form-control @error('tanggal_lelang')
                                is-invalid
                            @enderror">
                            @error('tanggal_lelang')
                                <strong class="invalid-feedback">Masukan Tanggal Lelang</strong>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Tanggal Selesai*</label>
                            <input type="datetime-local" name="tanggal_lelang_selesai"
                                class="form-control @error('tanggal_lelang')
                                is-invalid
                            @enderror">
                            @error('tanggal_lelang_selesai')
                                <strong class="invalid-feedback">Masukan Tanggal Selesai</strong>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror"
                                id="status">
                                <option value="" selected disabled>-PIlih Status-</option>
                                <option value="Dibuka" class="text-success">Dibuka</option>
                                <option value="Ditutup" class="text-danger">Ditutup</option>
                            </select>
                        </div>
                        {{-- <div class="form-floating mb-3">
                            <label for="">Stok yang diajukan*</label>
                            <input type="number" name="stok"
                                class="form-control @error('stok')
                                is-invalid
                            @enderror">
                            @error('stok')
                                <strong class="invalid-feedback">{{ $message }}</strong>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Simpan Data Lelang <i
                                class="fa-solid fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@foreach ($lelang as $index => $dataLelang)
    <div class="modal fade" id="editModal{{ $index }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit Lelang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/petugas/data/lelang/edit/' . $dataLelang->id_lelang) }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        {{-- <div class="form-floating mb-3">
                            <select name="id_barang" class="form-control @error('id_barang') is-invalid @enderror">
                                <option selected disabled>Pilih Barang</option>
                                @foreach ($barang as $dataBarang)
                                    <option value="{{ $dataBarang->id_barang }}"
                                        {{ $dataBarang->id_barang == $dataLelang->id_barang ? 'selected' : '' }}>
                                        {{ $dataBarang->nama_barang }} </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-floating mb-3">
                            <label for="">Tanggal Lelang*</label>
                            <input type="datetime-local" name="tanggal_lelang" class="form-control"
                                value="{{ $dataLelang->tanggal_lelang }}">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Tanggal Selesai*</label>
                            <input type="datetime-local" name="tanggal_lelang_selesai" class="form-control"
                                value="{{ $dataLelang->tanggal_lelang_selesai }}">
                        </div>
                        <div class="form-floating mb-3">
                            <label for="">Status*</label>
                            <select name="status" class="form-control" id="">
                                <option value="" selected disabled>-Pilih Status-</option>
                                <option class="text-success" value="Dibuka"
                                    {{ $dataLelang->status == 'Dibuka' ? 'selected' : '' }}>DIBUKA</option>
                                <option class="text-danger" value="Ditutup"
                                    {{ $dataLelang->status == 'Ditutup' ? 'selected' : '' }}>DITUTUP</option>
                            </select>
                        </div>
                        {{-- <div class="form-floating mb-3">
                            <label for="">Stok*</label>
                            <input type="number" name="stok" class="form-control"
                                value="{{ $dataLelang->stok }}">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-check-circle"></i>
                            Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">Close
                        </button>
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

<script>
    // DELETE BARANG
    $('.deleteLelang').click(function() {
        let id = $(this).attr('data-id');
        let nama = $(this).attr('data-nama');
        swal({
                title: "HAPUS DATA LELANG?",
                text: "Yakin data ini sudah tidak dibutuhkan? < " + nama + " > ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = "/petugas/data/lelang/delete/" + id + ""
                    swal("Data Lelang Telah Berhasil Dihapus!", {
                        icon: "success",
                    });
                } else {
                    swal("OK! Gajadi Hapus Data Barang");
                }
            });
    } );

    // DATATABLE PRINT
    $(document).ready(function() {
    let table = $('#dataTable').DataTable( {
        buttons: [ 'pdf', 'excel', 'copy', 'print' ],
        dom:
        "<'row'<'col-md-2'l><'col-md-5'B><'col-md-4'f>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-md-5'i><'col-md-7'p>>",
        lengthMenu: [ 
            [5,10,25,50,100,-1], 
            [5,10,25,50,100,"ALL"] 
        ]
    } );
    table.buttons().container()
        .appendTo( '#dataTable_wrapper .col-md-5:eq(0)' );
    } );
</script>