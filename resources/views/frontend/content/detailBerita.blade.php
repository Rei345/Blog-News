@extends('frontend.layout.main')
@section('content')
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5">
            <div class="col-lg-3">
                <div class="d-flex align-items-center mt-lg-5 mb-4">
                    <img class="img-fluid rounded-circle" src="{{ $berita->user->profile_picture }}" alt="..." />
                    <div class="ms-3">
                        <div class="fw-bold">{{ $berita->user->name }}</div>
                        <div class="text-muted">{{ $berita->kategori->nama_kategori }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1">{{ $berita->judul_berita }}</h1>
                        <!-- Post meta content-->
                        <div class="text-muted fst-italic mb-2">{{ $berita->created_at->format('d M Y') }}</div>
                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4"><img class="img-fluid rounded" src="{{ route('storage', $berita->gambar_berita) }}" alt="{{ $berita->judul_berita }}" /></figure>
                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">{!! $berita->isi_berita !!}</p>
                    </section>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection