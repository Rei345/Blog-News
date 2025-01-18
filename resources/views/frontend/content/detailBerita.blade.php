@extends('frontend.layout.main')
@section('content')
<section>
    <div class="container px-4 my-4">
        <div class="row gx-5">
            <div class="col-lg-3">
                <div class="d-flex align-items-center mt-lg-5 mb-4">
                    <img class="img-fluid rounded-circle w-25 border" src="{{ isset($berita->user->profile_picture) ? asset('storage/' . $berita->user->profile_picture) : asset('assets/img/undraw_profile.svg') }}" alt="..." />
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
                        <div class="text-muted fst-italic mb-2">{{ $berita->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</div>
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