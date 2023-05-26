@include('_partials.masyarakat.header', ['title' => 'Dashboard'])

<section id="dahsboard-masyarakat">
    <div class="container-fluid">
        <span class="text-white bg-danger badge-pill shadow-sm mt-2"># Sedang di Lelang</span>
        <br>
        {{-- $tb_lelang dari MasyarakatController --}}
        <div class="row text-center text-center justify-content-center">

            @if (count($tb_lelang)==0)
                <span class="text-danger text-center font-weight-bold mt-5">- TIDAK ADA BARANG YANG DILELANG -</span>
            @endif

            @foreach ($tb_lelang as $index => $data)
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="card shadow-sm mt-3 bg-warning text-black">
                        <div class="card-header">
                            <p class="text-white badge badge-pill bg-primary">Diupload pada: {{ \Carbon\Carbon::parse($data->tanggal_lelang)->format('d/m/Y H:i') }} | {{ Str::upper($data->status) }}</p>
                            <div class="row justify-content-around">
                                <div class="col-4">
                                    <img height="150" class="rounded shadow-sm"
                                        src="{{ url("assets/admin/image/barang/{$data->barang->foto_barang}") }}"
                                        alt="Foto Barang">
                                </div>
                                <div class="col-6 ml-3">
                                    <h6 class="card-title font-weight-bold text-primary">
                                        {{ Str::upper($data->barang->nama_barang) }}</h6>
                                    <p class="card-text fw-lighter font-weight-bold text-danger">
                                        Harga Awal: Rp. {{ number_format($data->barang->harga_awal, 0, ',', '.') }}
                                    </p>
                                    <hr class="bg-primary">
                                    <p class="text-dark font-weight-bold">Deskripsi Barang:
                                        {{ $data->barang->deskripsi_barang }}</p>
                                    <hr>
                                    <h6 class="text-danger font-weight-bold">Berakhir: {{ \Carbon\Carbon::parse( $data->tanggal_lelang_selesai )->format('d/m/Y H:i') }}</h6>
                                    <a href="{{ url('masyarakat/data/penawaran/' . $data->id_lelang) }}" class="btn btn-success shadow-sm"><i class="fas fa-comment-dollar"></i> Tawarkan Segera!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('_partials.masyarakat.footer')
