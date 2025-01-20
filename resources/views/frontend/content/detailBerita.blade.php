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
                <section>
                    <div class="card bg-light">
                        <div class="card-body">
                            <!-- Comment form-->
                            <form class="mb-4"><textarea class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea></form>
                            <!-- Comment with nested comments-->
                            <div class="d-flex mb-4">
                                <!-- Parent comment-->
                                <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                <div class="ms-3">
                                    <div class="fw-bold">Commenter Name</div>
                                    If you're going to lead a space frontier, it has to be government; it'll never be private enterprise. Because the space frontier is dangerous, and it's expensive, and it has unquantified risks.
                                    <!-- Child comment 1-->
                                    <div class="d-flex mt-4">
                                        <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                        <div class="ms-3">
                                            <div class="fw-bold">Commenter Name</div>
                                            And under those conditions, you cannot establish a capital-market evaluation of that enterprise. You can't get investors.
                                        </div>
                                    </div>
                                    <!-- Child comment 2-->
                                    <div class="d-flex mt-4">
                                        <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                        <div class="ms-3">
                                            <div class="fw-bold">Commenter Name</div>
                                            When you put money directly to a problem, it makes a good headline.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Single comment-->
                            <div class="d-flex">
                                <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                <div class="ms-3">
                                    <div class="fw-bold">Commenter Name</div>
                                    When I look at the universe and all the ways the universe wants to kill us, I find it hard to reconcile that with statements of beneficence.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            </div>
        </div>
    </div>
</section>
@endsection