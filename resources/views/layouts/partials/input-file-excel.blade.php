<form id="importForm" action="{{ $routeImport }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <input class="form-control mb-2" type="file" id="fileInput" required name="file" accept=".xlsx">
        <small>Belum punya template mahasiswa? <a href="{{ $pathDownload }}">Download</a></small>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
        </button>
        <button type="sumbit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Import</span>
        </button>
    </div>
</form>
