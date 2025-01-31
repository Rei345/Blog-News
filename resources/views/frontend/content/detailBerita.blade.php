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
                                                src="{{ $comment->commentable->foto_profile ?? asset('assets/img/default-avatar.png') }}" alt="Avatar" />                                    
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

                                        <!-- Like Button -->
                                        <button class="btn btn-sm btn-outline-primary like-btn" data-id="{{ $comment->id }}">
                                            <i class="fas fa-thumbs-up"></i> Like (<span class="like-count">{{ $comment->likes->count() }}</span>)
                                        </button>                                        

                                        <!-- Reply Button -->
                                        <button class="btn btn-sm btn-outline-secondary reply-btn" data-id="{{ $comment->id }}">
                                            <i class="fas fa-reply"></i> Reply
                                        </button>

                                        <!-- Form Balasan (Hidden by Default) -->
                                        <form class="reply-form mt-2" data-id="{{ $comment->id }}" style="display: none;">
                                            <input type="text" class="form-control reply-input" placeholder="Write a reply..." />
                                            <button type="button" class="btn btn-primary btn-sm submit-reply">Submit</button>
                                        </form>

                                        <!-- Menampilkan balasan komentar -->
                                        @if ($comment->replies->count() > 0)
                                        <button class="btn btn-sm btn-link show-replies-btn" data-id="{{ $comment->id }}">
                                            Lihat Semua Balasan ({{ $comment->replies->count() }})
                                        </button>
                                        @endif

                                        <!-- Menampilkan balasan komentar -->
                                        <div class="replies mt-2" data-id="{{ $comment->id }}" style="display: none;">
                                            @foreach ($comment->replies as $reply)
                                                <div class="d-flex align-items-start mt-2">
                                                    @php
                                                        $commenter = $reply->commentable;
                                                        $avatar = asset('assets/img/default-avatar.png'); // Default avatar
                                        
                                                        if ($commenter) {
                                                            if ($reply->commentable_type == \App\Models\User::class) {
                                                                $avatar = $commenter->profile_picture ? asset('storage/' . $commenter->profile_picture) : $avatar;
                                                                $name = $commenter->name;
                                                            } elseif ($reply->commentable_type == \App\Models\Pengunjung::class) {
                                                                $avatar = $commenter->foto_profile ? $commenter->foto_profile : $avatar;
                                                                $name = $commenter->nama_pengunjung;
                                                            } else {
                                                                $name = "Anonymous";
                                                            }
                                                        }
                                                    @endphp
                                        
                                                    <img src="{{ $avatar }}" alt="Profile" class="rounded-circle" width="30">
                                                    <div class="ms-2">
                                                        <strong>{{ $name }}</strong>: {{ $reply->reply }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Like Comment
        document.querySelectorAll(".like-btn").forEach(button => {
            button.addEventListener("click", function () {
                let userLoggedIn = "{{ auth('pengunjung')->check() || auth('user')->check() }}";
                if (!userLoggedIn) {
                    alert("You need to log in to like a comment!");
                    return;
                }
                let commentId = this.getAttribute("data-id");
                let likeCountElement = this.querySelector(".like-count");

                fetch("{{ route('comment.like', ['slug' => $berita->slug]) }}", { 
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id_comment: commentId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === "Liked") {
                        likeCountElement.textContent = parseInt(likeCountElement.textContent) + 1;
                    } else {
                        likeCountElement.textContent = parseInt(likeCountElement.textContent) - 1;
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle Reply Form
        document.querySelectorAll(".reply-btn").forEach(button => {
            button.addEventListener("click", function () {
                let commentId = this.getAttribute("data-id");
                let replyForm = document.querySelector(`.reply-form[data-id='${commentId}']`);

                if (replyForm) {
                    replyForm.style.display = replyForm.style.display === "none" ? "block" : "none";
                }
            });
        });

        // Submit Reply
        let isAuthenticated = document.querySelector('meta[name="user-auth"]').content === "1";
        document.querySelectorAll(".submit-reply").forEach(button => {
            button.addEventListener("click", function () {
                let userLoggedIn = "{{ auth('pengunjung')->check() || auth('user')->check() }}";
                if (!userLoggedIn) {
                    alert("You need to log in to reply!");
                    return;
                }

                let commentId = this.closest(".reply-form").getAttribute("data-id");
                let replyInput = this.previousElementSibling;
                if (replyInput.value.trim() === "") {
                    alert("Reply cannot be empty!");
                    return;
                }

                fetch("{{ route('comment.reply', ['slug' => $berita->slug]) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id_comment: commentId, reply: replyInput.value }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    let repliesContainer = document.querySelector(`.replies[data-id="${commentId}"]`);
                    if (repliesContainer) {
                        repliesContainer.innerHTML += `
                            <div class="mt-2 d-flex">
                                <img src="${data.user.avatar}" alt="Profile" class="rounded-circle" width="30">
                                <div class="ms-2">
                                    <strong>${data.user.name}</strong>: ${data.reply}
                                </div>
                            </div>`;
                    }
                    replyInput.value = "";
                })
                .catch(error => console.error("Error:", error));
            });
        });
    });
</script>
{{-- JQuery untuk menampilkan dan menyembunyikan komentar --}}
<script>
    $(document).ready(function () {
        $(".show-replies-btn").click(function () {
            var commentId = $(this).data("id");
            var repliesDiv = $(".replies[data-id='" + commentId + "']");
            
            if (repliesDiv.is(":visible")) {
                repliesDiv.slideUp();
                $(this).text("Lihat Semua Balasan (" + repliesDiv.children().length + ")");
            } else {
                repliesDiv.slideDown();
                $(this).text("Sembunyikan Balasan");
            }
        });
    });
</script>
@endsection