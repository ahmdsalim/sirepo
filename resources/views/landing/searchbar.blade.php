<form action="{{ route('landing.search') }}" method="GET" id="searchFrom">
    <input class="form-control py-3 px-4 shadow-sm mt-3 " type="search" id="searchInput" name="search"
        placeholder="Cari Judul, Penulis, Pembimbing, Penguji">
</form>


@push('scripts')
    <script>
        document.getElementById("searchInput").addEventListener("keydown", function(event) {
            if (event.keyCode === 'Enter') {
                event.preventDefault();
                document.getElementById("searchForm").submit();
            }
        });
    </script>
@endpush
