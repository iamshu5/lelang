<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <div class='container-fluid'>
        <h6 class="h6 font-italic text-white mt-5 text-center">DETAIL PRODUCT</h6>
        <div class="card mx-auto col-md-3 col-10 mt-3 pt-4 rounded shadow">
            <div class="d-flex sale justify-content-beetwen">
                <a href="{{ url('/') }}" class="btn btn-warning btn-sm mb-1 text-white shadow-sm mr-5 ms-auto"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5ZM10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5Z"/>
                  </svg>Back</a>
                <a href="{{ url('masyarakat/dashboard') }}" class="btn btn-danger btn-sm mb-1 font-weight-bolder shadow-sm">TAWARKAN CEPAT!</a>
            </div>
            <img class='mx-auto img-thumbnail'
                src="{{ url("assets/admin/image/barang/{$barang->foto_barang}") }}"
                width="auto" height="auto"/>
            <div class="card-body text-center mx-auto">
                <h5 class="card-title font-italic">{{ Str::upper( $barang->nama_barang ) }}</h5>
                <p class="card-text text-danger">Rp. {{ number_format( $barang->harga_awal ) }}</p>
                <h5 class="h5 font-weight-light font-italic">Deskripsi Barang: <br> {{ $barang->deskripsi_barang }}</h5>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
