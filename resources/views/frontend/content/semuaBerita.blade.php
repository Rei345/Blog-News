@extends('frontend.layout.main')
@section('content')
<!-- Blog preview section-->
<section class="py-3">
    <div class="container px-4">
        <h1 class="fw-bolder fs-5 mb-4">Semua Berita {{ $kategoriTerpilih }}</h1>
        
        @if (!empty($query))
            <p>Hasil pencarian untuk: <strong>{{ $query }}</strong></p>
        @endif

        <!-- Kontainer Hasil Pencarian -->
        <div id="card-container" class="row gx-5">
            @forelse ($berita as $row)
                <div class="col-lg-4 mb-5">
                    <div class="card h-100 shadow border-0">
                        <img class="card-img-top" src="{{ $row->gambar_berita ? route('storage', $row->gambar_berita) : asset('default-image.jpg') }}" alt="{{ $row->judul_berita }}" />
                        <div class="card-body p-4">
                            <div class="badge bg-primary bg-gradient rounded-pill mb-2">{{ $row->kategori->nama_kategori }}</div>
                            <a class="text-decoration-none link-dark stretched-link" href="{{ route('home.detailBerita', $row->slug) }}">
                                <div class="h5 card-title mb-3">{{ $row->judul_berita }}</div>
                            </a>
                            <p class="card-text mb-0">{!! substr($row->isi_berita, 0, 200) !!}</p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="small">
                                        <div class="fw-bold">{{ $row->user->name }}</div>
                                        <div class="text-muted">{{ $row->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada berita ditemukan.</p>
            @endforelse
        </div>

        <div class="text-end mb-5 mb-xl-0">
            <a class="text-decoration-none" href="{{ route('home.berita') }}">
                More stories
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            let query = $(this).val();

            $.ajax({
                type: 'GET',
                url: '{{ route("search") }}',
                data: { search: query },
                success: function (response) {
                    if (response.html) {
                        $('#card-container').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
