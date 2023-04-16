@php $user = Illuminate\Support\facades\Auth::user(); @endphp
@include('_partials.admin.header', ['title' => 'Dashboard'])
<div class="container-fluid">
    <div class="row justify-content-around">
        <div class="col-12">
            <h5>Selamat Datang, <strong> {{ $user->nama_petugas }} </strong></h5>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <span href="{{ url('/admin/data/lelang') }}"
                class=" px-3 card border-left-info shadow-sm h-100 py-2 text-decoration-none">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                TOTAL DILELANG</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $tb_lelang }} - DATA DILELANG</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-cubes fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
            </span>
        </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ url('/admin/data/barang') }}"
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

    <div class="col-xl-3 col-md-6 mb-2">
        <a href="{{ url('/admin/data/masyarakat') }}"
            class=" px-3 card border-left-warning shadow-sm h-100 py-2 text-decoration-none">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            TOTAL MASYARAKAT</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $masyarakat }} - DATA MASYARAKAT</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-users fa-2x text-gray-500"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<hr>
<span class="text-white bg-info badge-pill shadow-sm">Barang dilelang</span>
    <div class="row text-center">
        @php $no=1; @endphp
        @foreach ( $lelang as $index => $data)
        @if ($data->status == 'Dibuka')
        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm mt-3 text-black rounded">
                <span class="">{{ $no++ }}</span>
                <div class="card-header rounded">
                    <p class="text-white badge badge-pill bg-primary">Diupload pada: {{ \Carbon\Carbon::parse($data->tanggal_lelang)->format('d/m/Y H:i') }} | {{ Str::upper($data->status) }}</p> <br>
                    <p class="text-white badge badge-pill bg-primary">Yang mengupload: {{ $data->petugas->nama_petugas }}</p>
                    {{-- <p class="text-white badge badge-pill bg-primary">Berakhir pada: {{ $tb_lelang->tb_lelang->tanggal_lelang_selesai }}</p> --}}
                    <div class="row justify-content-around">
                        <div class="col-4">
                            <img height="150" class="rounded shadow-sm"
                                src="{{ url("assets/admin/image/barang/{$data->barang->foto_barang}") }}" alt="Foto Barang">
                        </div>
                        <div class="col-6 ml-3">
                            <h6 class="card-title font-weight-bold text-primary">{{ Str::upper($data->barang->nama_barang) }}</h6>
                            <p class="card-text fw-lighter font-weight-bold text-danger">
                                Rp. {{ number_format($data->barang->harga_awal, 0, ',', '.') }}
                            </p>
                            <hr class="bg-primary">
                            <p class="text-dark font-weight-bold">Deskripsi Barang: {{ $data->barang->deskripsi_barang }}</p>
                            <a href="{{ url('admin/detail/penawaran/barang/' . $data->id_lelang) }}" class="btn btn-primary shadow-sm">Detail Para Penawar</a>
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