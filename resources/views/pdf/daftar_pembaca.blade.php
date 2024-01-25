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
    <title>Daftar Pembaca</title>
</head>
<body style="text-align: center;">
<h2>Daftar Pembaca</h2>

<table>
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th>NISN/NIP</th>
    <th>Email</th>
    <th>Role</th>
    <th>Buku Dibaca</th>
  </tr>
  @foreach ($data as $pembaca)
  <tr>
    <td>{{$loop->iteration}}</td>
    <td>{{ $pembaca->nama }}</td>
    <td>@if ($pembaca->role == 'siswa') {{$pembaca->userable->nisn}} @else {{$pembaca->userable->nip}} @endif</td>
    <td>{{ $pembaca->email }}</td>
    <td>{{ $pembaca->role }}</td>
    <td>{{ count($pembaca->baca()->orderBy('end_at','desc')->get()->unique('buku_id')) }}</td>    
  </tr>
  @endforeach
</table>

</body>
</html>