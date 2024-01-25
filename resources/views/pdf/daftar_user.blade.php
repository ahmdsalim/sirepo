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
    <title>Daftar User</title>
</head>
<body style="text-align: center;">
<h2>Daftar User</h2>

<table>
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Role</th>
    <th>Status</th>
  </tr>
  @foreach ($data as $user)
  <tr>
    <td>{{$loop->iteration}}</td>
    <td>{{ $user->nama }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
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


