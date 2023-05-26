@php $user = Illuminate\Support\Facades\Auth::user(); @endphp
@include('_partials.admin.header', ['title' => 'Dashboard'])

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h5>Selamat Datang, <strong> {{ $user->nama_petugas }} </strong></h5>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('petugas/data/lelang') }}"
                class=" px-3 card border-left-info shadow-sm h-100 py-2 text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                TOTAL DILELANG</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $tb_lelang }} - DATA TELAH DILELANG</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-cubes fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/petugas/data/barang') }}"
                class=" px-3 card border-left-success shadow-sm h-100 py-2 text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                TOTAL BARANG</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $dbarang }} - DATA BARANG</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-boxes-packing fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <hr>
    <span class="text-white bg-danger badge-pill shadow-sm">Sedang dilelang</span>
    @if (count($lelang)==0)
        <div class="d-flex justify-content-center">
            <span class="text-danger font-weight-bold">Sedang tidak ada yang dilelang...</span>
        </div>        
    @endif
    <div class="row justify-content-around text-center">
        @if (count($lelang)==0)
            <span class="text-danger mt-3">Tidak ada data dilelang</span>
        @endif
        
        @foreach ( $lelang as $index => $data)
            @if ($data->status == 'Dibuka')
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="card shadow-sm mt-3 bg-warning text-black">
                        <div class="card-header">
                            <p class="text-white badge badge-pill bg-primary">Diupload pada: {{ \Carbon\Carbon::parse($data->tanggal_lelang)->format('d/m/Y H:i') }}</p>
                            <p class="text-white badge badge-pill bg-primary">Berakhir pada: {{ \Carbon\Carbon::parse($data->tanggal_lelang_selesai)->format('d/m/Y H:i') }}</p> 
                            <br>
                            <p class="text-white badge badge-pill bg-primary">Status: {{ Str::upper($data->status) }}</p>
                            <div class="row justify-content-around">
                                <div class="col-4">
                                    <img height="150" class="rounded shadow-sm"
                                        src="{{ url("assets/admin/image/barang/{$data->barang->foto_barang}") }}" alt="Foto Barang">
                                </div>
                                <div class="col-6 ml-3">
                                    <h6 class="card-title font-weight-bold text-primary">{{ Str::upper($data->barang->nama_barang) }}
                                    </h6>
                                    <p class="card-text fw-lighter font-weight-bold text-danger">
                                        Rp. {{ number_format($data->barang->harga_awal, 0, ',', '.') }}
                                    </p>
                                    <hr>
                                    <p class="text-dark font-weight-bold">Deskripsi Barang: {{ $data->barang->deskripsi_barang }}</p>
                                     <a href="{{ url('petugas/detail/penawaran/barang/' . $data->id_lelang) }}" class="btn btn-primary shadow-sm">Detail Para Penawar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

@include('_partials.admin.footer')
