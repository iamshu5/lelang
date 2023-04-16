@include('_partials.admin.header', ['title' => 'History Lelang'])

<section id="history-lelang">
    <div class="container-fluid">
        <div class="d-flex">
            <a href="{{ url('/petugas/data/history/lelang') }}"><i class="fas fa-sync-alt"></i> refresh</a>
        </div>
        <div class="row justify-content-end">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-clock"></i> History Lelang</li>
                    </ol>
                </nav>
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">Data History Lelang</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered rounded" id="dataTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Lelang</th>
                                        <th>Nama Penawar</th>
                                        <th>Penawaran Harga</th>
                                        <th>Harga Barang</th>
                                        <th>Barang yang ditawarkan</th>
                                        <th>Tanggal Menawar</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if (count($history_lelang)==0)
                                        <td colspan="8" class="bg-gradient-danger text-white fw-bold text-center">Tidak ada History Lelang</td>
                                    @endif --}}
                                    
                                    @php $no = 1; @endphp
                                    @foreach ($history_lelang as $index => $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->id_lelang }}</td>
                                        <td>{{ $data->masyarakat->nama_masyarakat }}</td>
                                        <td>Rp. {{ number_format($data->penawaran_harga) }}</td>
                                        <td>Rp. {{ number_format($data->barang->harga_awal) }}</td>
                                        <td>{{ $data->barang->nama_barang }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal_nawar)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ url('petugas/detail/penawaran/barang/' . $data->id_lelang) }}" class="btn btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
    $(document).ready(function() {
        let table = $('#dataTable').DataTable( {
        buttons: [ 'pdf', 'excel', 'copy', 'csv', 'print' ],
        dom:
        "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" + 
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