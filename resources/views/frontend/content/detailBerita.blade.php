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

                {{-- Share Content --}}
                <div class="share-buttons mb-4">
                    <span class="me-2 fw-bold">Share to:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('home.detailBerita', $berita->slug)) }}" 
                        target="_blank" class="btn btn-primary">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('home.detailBerita', $berita->slug)) }}&text={{ urlencode($berita->judul_berita) }}" 
                        target="_blank" class="btn btn-info">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode(route('home.detailBerita', $berita->slug)) }}" 
                        target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode($berita->judul_berita) }}&body={{ urlencode(route('home.detailBerita', $berita->slug)) }}" 
                        class="btn btn-secondary">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
                
                <!-- Comments section-->
                @if (auth()->check())
                    <section class="mt-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Comment ({{ $comments->count() }})</h5>
                                <!-- Single Comment -->
                                @foreach ($comments as $comment)
                                    <div class="d-flex mb-4">
                                        <div class="flex-shrink-0">
                                            <img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="Avatar" />
                                        </div>
                                        <div class="ms-3">
                                            <div class="fw-bold">{{ $comment->user->name }}</div>
                                            <p class="mb-0">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Comment Form -->
                                <form class="d-flex align-items-start" action="{{ route('home.postComment', $berita->slug) }}" method="POST">
                                    @csrf
                                    <textarea class="form-control me-2" name="comment" rows="3" placeholder="Join the discussion and leave a comment!" style="flex-grow: 1;"></textarea>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="height: 100%; width: 45px;">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>                          
                @else
                    <p class="text-muted">Please <a href="{{ route('auth.index') }}">log in</a> to leave a comment.</p>
                @endif
            </div>
            </div>
        </div>
    </div>
</section>
@endsection