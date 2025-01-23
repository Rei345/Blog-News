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
                <section class="mt-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Comment ({{ $comments->count() }})</h5>
                
                            <!-- Single Comment -->
                            @foreach ($comments as $comment)
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <!-- Menampilkan avatar berdasarkan apakah yang memberikan komentar user atau pengunjung -->
                                        @if ($comment->commentable_type == \App\Models\User::class)
                                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $comment->commentable->profile_picture) }}" alt="Avatar" />
                                        @elseif ($comment->commentable_type == \App\Models\Pengunjung::class)
                                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $comment->commentable->foto_profile) }}" alt="Avatar" />
                                        @else
                                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                src="https://sguru.org/wp-content/uploads/2017/06/cool-anonymous-profile-pictures-VDWrWSva.jpg" alt="Avatar" />
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <!-- Menampilkan nama sesuai dengan commentable_type -->
                                        <div class="fw-bold">
                                            @if ($comment->commentable_type == \App\Models\User::class)
                                                {{ $comment->commentable->name }}  <!-- Nama untuk User -->
                                            @elseif ($comment->commentable_type == \App\Models\Pengunjung::class)
                                                {{ $comment->commentable->nama_pengunjung }}  <!-- Nama untuk Pengunjung -->
                                            @else
                                                Anonymous
                                            @endif
                                        </div>
                                        <p class="mb-0">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                
                            <div id="comments">
                                <!-- Komentar akan ditambahkan di sini -->
                            </div>
                
                            <!-- Comment Form -->
                            <form 
                                id="commentForm"
                                class="d-flex align-items-start" 
                                action="{{ route('home.postComment', $berita->slug) }}" 
                                method="POST"
                                @if (!auth('pengunjung')->check() && !auth('user')->check()) 
                                    onsubmit="event.preventDefault(); alert('You need to log in to post a comment!');" 
                                @endif
                            >
                                @csrf
                                <textarea 
                                    class="form-control me-2" 
                                    name="comment" 
                                    rows="3" 
                                    placeholder="Join the discussion and leave a comment!" 
                                    style="flex-grow: 1;"
                                    {{ !(auth('pengunjung')->check() || auth('user')->check()) ? 'disabled' : '' }}
                                ></textarea>
                
                                @if (auth('pengunjung')->check() || auth('user')->check())
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary d-flex align-items-center justify-content-center" 
                                        style="height: 100%; width: 45px;"
                                    >
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                @else
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary d-flex align-items-center justify-content-center" 
                                        style="height: 100%; width: 45px;"
                                        disabled
                                    >
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                @endif                             
                            </form>
                
                            <!-- Alert for non-logged-in users -->
                            @if (!auth('pengunjung')->check() && !auth('user')->check())
                                <p class="text-muted mt-2">
                                    <strong>Note:</strong> Please <a href="{{ route('auth.index') }}">log in</a> to leave a comment.
                                </p>
                            @endif
                        </div>
                    </div>
                </section>                
            </div>
        </div>
    </div>
</section>
<script>
    $('#commentForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah reload halaman
        const formData = $(this).serialize(); // Ambil data form

        $.ajax({
            url: "{{ route('home.postComment', $berita->slug) }}", // Endpoint komentar
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response && response.user && response.comment) {
                    $('#comments').append(`
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <img class="rounded-circle" src="${response.user.avatar}" alt="Avatar" />
                        </div>
                        <div class="ms-3">
                            <div class="fw-bold">${response.user.name}</div>
                            <p class="mb-0">${response.comment}</p>
                        </div>
                    </div>
                    `);
                    $('#commentForm')[0].reset(); // Reset form setelah submit
                } else {
                    alert('Error: Data tidak valid.');
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
            }
        });
    });
</script>
@endsection