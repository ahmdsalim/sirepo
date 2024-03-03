<form id="importForm" action="{{$routeImport}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <input class="form-control mb-2" type="file" id="fileInput" required name="file" accept=".xlsx">
        <small>Belum punya template mahasiswa? <a href="#">Download</a></small>
    </div>
    <div class="col-12 d-flex justify-content-end ">
        <button type="sumbit" class="btn btn-primary">Import</button>
    </div>
</form>