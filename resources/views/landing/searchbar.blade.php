<form action="{{ route('landing.search') }}" method="GET" id="searchFrom">
    @csrf
    <input class="form-control py-3 px-4 shadow-sm" type="search" id="searchInput" name="search"
        placeholder="Judul,Author,Proyek1,Proyek2,...." value="{{ session('searchKeyword') }}">
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
