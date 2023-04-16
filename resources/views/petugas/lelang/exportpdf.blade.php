<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #1ac1df;
  color: white;
}
</style>
</head>
<body>

<h1>Laporan Pelelangan Shu</h1>

<table id="customers">
  <tr>
    <th>#</th>
    <th>Nama Barang</th>
    <th>Tanggal Lelang Mulai</th>
    <th>Tanggal Lelang Selesai</th>
    <th>Harga Awal</th>
    <th>Harga Akhir</th>
    <th>Winner</th>
    <th>Status</th>
  </tr>
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
  </tr>
@endforeach
</table>
</body>
</html>