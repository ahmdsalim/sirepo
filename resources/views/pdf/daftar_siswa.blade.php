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
    <title>Daftar Siswa</title>
</head>
<body style="text-align: center;">
<h2>Daftar Siswa</h2>

<table>
  <tr>
    <th>No</th>
    <th>NISN</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Telepon</th>
  </tr>
  @foreach ($data as $siswa)
  <tr>
    <td>{{$loop->iteration}}</td>
    <td>{{ $siswa->nisn }}</td>
    <td>{{ $siswa->nama }}</td>
    <td>{{ $siswa->jk }}</td>
    <td>{{ $siswa->telepon }}</td>
  </tr>
  @endforeach
</table>

</body>
</html>


