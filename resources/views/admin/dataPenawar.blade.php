@include('_partials.admin.header', ['title' => 'Detail Penawar'])

<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fa-solid fa-circle-info"></i> Detail History Lelang</li>
        </ol>
    </nav>
    <div class="d-flex">
        <a href="{{ url('admin/dashboard') }}" class="btn btn-outline-dark btn-sm">Kembali</a>
    </div>
    <div class="row text-center justify-content-center">
        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm mt-3 mb-3 bg-warning text-black">
                <div class="card-header">
                    {{-- Diupload pada: {{ \Carbon\Carbon::parse($tb_lelang->tanggal_lelang)->format('d-m-Y H:i') }} --}}
                    <p class="text-white badge badge-pill bg-primary">
                        STATUS: {{ Str::upper($tb_lelang->status) }}</p>
                    <div class="row justify-content-around">
                        <div class="col-4">
                            <img height="150" class="rounded shadow-sm"
                                src="{{ url("assets/admin/image/barang/{$barang->foto_barang}") }}" alt="Foto Barang">
                        </div>
                        <div class="col-6 ml-3">
                            <h6 class="card-title font-weight-bold text-primary">
                                {{ Str::upper($barang->nama_barang) }}</h6>
                            <p class="card-text fw-lighter font-weight-bold text-danger">
                                Harga Awal: Rp. {{ number_format($barang->harga_awal, 0, ',', '.') }}
                            </p>
                            <hr class="bg-primary">
                            <p class="text-dark font-weight-bold">Deskripsi Barang:
                                {{ $barang->deskripsi_barang }}</p>
                            <hr>
                            <h6 class="h6 font-weight-bold">Pemenang: {{ is_object($tb_lelang->masyarakat) ? $tb_lelang->masyarakat->nama_masyarakat : '' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
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
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mt-3">
                <div class="card-header bg-info text-white">List Para Penawar</div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Penawar</th>
                                <th>Harga yang ditawarkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($tb_lelang->history_lelang->sortByDesc('penawaran_harga') as $index => $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->masyarakat->nama_masyarakat }}</td>
                                    <td>Rp. {{ number_format($data->penawaran_harga) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('_partials.admin.footer')