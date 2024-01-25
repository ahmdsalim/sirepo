<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: center;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #25476a;
  color: white;
}
</style>
    <title>Daftar Sekolah</title>
</head>
<body style="text-align: center;">
<h2>Daftar Sekolah</h2>

<table>
  <tr>
    <th>No</th>
    <th>NPSN</th>
    <th>Nama</th>
    <th>Provinsi</th>
    <th>Telepon</th>    
    <th>Status</th>

  </tr>
  @foreach ($data as $sekolah)
  <tr>
    <td>{{$loop->iteration}}</td>
    <td>{{ $sekolah->npsn }}</td>
    <td>{{ $sekolah->nama }}</td>   
    <td>{{ $sekolah->provinsi }}</td>
    <td>{{ $sekolah->telepon }}</td>
    <td>@if ($sekolah->active)
        Aktif
        @else
        NonAktif
    @endif</td>
  </tr>
  @endforeach
</table>

</body>
</html>


