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
    <title>Daftar Guru</title>
</head>
<body style="text-align: center;">
<h2>Daftar Guru</h2>

<table>
  <tr>
    <th>No</th>
    <th>NIP</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Telepon</th>
  </tr>
  @foreach ($data as $guru)
  <tr>
    <td>{{$loop->iteration}}</td>
    <td>{{ $guru->nip }}</td>
    <td>{{ $guru->nama }}</td>
    <td>{{ $guru->jk }}</td>
    <td>{{ $guru->telepon }}</td>
  </tr>
  @endforeach
</table>

</body>
</html>


