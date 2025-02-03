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
                                <!-- Hidden input untuk membedakan komentar biasa atau reply -->
                                <input type="hidden" name="id_comment" id="id_comment" value=""> 

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
    $(document).ready(function () {
        let isReplying = false; // Status untuk melacak apakah sedang dalam mode reply
        let activeReplyBtn = null; // Menyimpan tombol reply yang aktif

        // Submit Komentar atau Balasan
        $('#commentForm').on('submit', function (e) {
            e.preventDefault();

            const formData = {
                comment: $('textarea[name="comment"]').val(),
                id_comment: $('#id_comment').val(),
            };

            $.ajax({
                url: "{{ route('home.postComment', $berita->slug) }}",
                type: 'POST',
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response && response.user) {
                        const avatar = response.user.avatar;
                        const name = response.user.name;

                        const commentHtml = `
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <img class="rounded-circle" src="${avatar}" alt="Avatar" width="40" />
                                </div>
                                <div class="ms-3">
                                    <div class="fw-bold">${name}</div>
                                    <p class="mb-0">${response.comment || response.reply}</p>
                                    <button class="btn btn-sm btn-outline-primary like-btn" data-id="${response.id}">
                                        <i class="fas fa-thumbs-up"></i> Like (<span class="like-count">0</span>)
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary reply-btn" data-id="${response.id}">
                                        <i class="fas fa-reply"></i> Reply
                                    </button>
                                </div>
                            </div>
                        `;

                        if (response.comment) {
                            // Untuk komentar utama
                            $('#comments').append(commentHtml);
                        } else if (response.reply) {
                            // Untuk balasan (reply)
                            const replyHtml = `
                                <div class="d-flex align-items-start mt-2">
                                    <img src="${avatar}" alt="Profile" class="rounded-circle" width="30">
                                    <div class="ms-2">
                                        <strong>${name}</strong>: ${response.reply}
                                    </div>
                                </div>
                            `;

                            // Menampilkan balasan di bawah komentar terkait
                            const repliesContainer = $(`.replies[data-id="${formData.id_comment}"]`);
                            if (repliesContainer.length) {
                                repliesContainer.append(replyHtml).show();
                            } else {
                                // Jika kontainer balasan belum ada, buat baru
                                $(`.reply-btn[data-id="${formData.id_comment}"]`).closest('.ms-3').append(`
                                    <div class="replies mt-2" data-id="${formData.id_comment}">
                                        ${replyHtml}
                                    </div>
                                `);
                            }
                        }

                        $('#commentForm')[0].reset();
                        $('#id_comment').val('');
                        isReplying = false;
                        if (activeReplyBtn) {
                            activeReplyBtn.removeClass('active-reply'); // Hapus highlight
                            activeReplyBtn = null;
                        }
                    } else {
                        alert('Error: Data tidak valid.');
                    }
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.error || 'Terjadi kesalahan.');
                }
            });
        });

        // Event delegation untuk tombol reply
        $(document).on('click', '.reply-btn', function (e) {
            e.stopPropagation(); // Mencegah trigger event klik pada dokumen

            const commentId = $(this).data('id');

            // Toggle reply mode
            if (isReplying && activeReplyBtn && activeReplyBtn.is(this)) {
                // Membatalkan mode reply jika tombol yang sama diklik lagi
                $('#id_comment').val('');
                $(this).removeClass('active-reply');
                isReplying = false;
                activeReplyBtn = null;
            } else {
                // Mengaktifkan mode reply
                $('#id_comment').val(commentId);
                $('textarea[name="comment"]').focus();

                // Highlight tombol reply yang aktif
                $('.reply-btn').removeClass('active-reply');
                $(this).addClass('active-reply');

                isReplying = true;
                activeReplyBtn = $(this);
            }
        });

        // Membatalkan reply dengan klik di area kosong
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#commentForm, .reply-btn').length && isReplying) {
                $('#id_comment').val('');
                $('.reply-btn').removeClass('active-reply');
                isReplying = false;
                activeReplyBtn = null;
            }
        });

        // Event delegation untuk tombol like
        $(document).on('click', '.like-btn', function () {
            let userLoggedIn = "{{ auth('pengunjung')->check() || auth('user')->check() }}";
            if (!userLoggedIn) {
                alert("You need to log in to like a comment!");
                return;
            }

            const commentId = $(this).data('id');
            const likeCountElement = $(this).find('.like-count');

            $.ajax({
                url: "{{ route('comment.like', ['slug' => $berita->slug]) }}",
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id_comment: commentId }),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.message === "Liked") {
                        likeCountElement.text(parseInt(likeCountElement.text()) + 1);
                        $(this).addClass('liked');
                    } else if (response.message === "Unliked") {
                        const currentCount = parseInt(likeCountElement.text());
                        likeCountElement.text(currentCount > 0 ? currentCount - 1 : 0);
                        $(this).removeClass('liked');
                    }
                },
                error: function () {
                    alert('Gagal menyukai komentar.');
                }
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