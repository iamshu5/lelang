@include('_partials.masyarakat.header', ['title' => 'History Lelang'])

<div class="container-fluid">
    <div class="row text-center justify-content-center">
        {{-- <div class="col-lg-5 col-md-12 col-sm-12 col-12">
            <div class="card shadow-sm mt-3 mb-3 bg-warning text-black">
                <div class="card-header">
                    <div class="row justify-content-around">
                        <div class="col-6 ml-3">
                            <h6 class="card-title font-weight-bold text-primary">
                                {{ Str::upper($history_masyarakat->barang->nama_barang) }}</h6>
                            <p class="card-text fw-lighter font-weight-bold text-danger">
                                Harga Awal: Rp. {{ number_format($barang->harga_awal, 0, ',', '.') }}
                            </p>
                            <hr class="bg-primary">
                            <p class="text-dark font-weight-bold">Deskripsi Barang:
                                {{ $barang->deskripsi_barang }}</p>
                            <hr> --}}
                            {{-- Form action tb_lelang dari function detailPenawaran --}}
                            {{-- <form action="{{ url('/masyarakat/penawaran/process/' . $tb_lelang->id_lelang) }}" method="POST">
                                @csrf
                                <input type="number"
                                    class="form-control @error('penawaran_harga')
                                    is-invalid @enderror"
                                    min="0" name="penawaran_harga" placeholder="Masukan Tawaran Anda!" required>
                                <button type="submit" class="btn btn-success btn-sm mt-2 shadow-sm">TAWARKAN!</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mt-3">
                <div class="card-header bg-info text-white">List Kamu Menawar</div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Barang Yang Kamu Pilih</th>
                                <th>Harga Yang Kamu Tawarkan</th>
                                <th>Tanggal Kamu Menawar</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($history_masyarakat as $index => $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->barang->nama_barang }}</td>
                                    <td>Rp. {{ number_format($data->penawaran_harga) }}</td>
                                    <td>{{ \Carbon\Carbon::parse( $data->tanggal_nawar )->format('d/m/Y') }}</td>
                                     <td> 
                                        <a href="{{ url('masyarakat/data/penawaran/' . $data->id_lelang) }}" class="btn btn-primary">Detail</a>
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

@include('_partials.masyarakat.footer')