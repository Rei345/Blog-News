<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Berita;
use App\Models\Comment;
use App\Models\Kategori;
use App\Models\CommentLike;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $menu = $this->getMenu();
        $berita = Berita::with('kategori')->latest()->take(6)->get()->unique('id_kategori');
        $mostViews = Berita::with('kategori')->orderByDesc('total_views')->take(3)->get();
        $kategori = Kategori::all();
        
        return view ('frontend.content.home', compact('menu', 'berita', 'mostViews', 'kategori'));
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $berita = Berita::where('judul_berita', 'LIKE', "%{$query}%")
            ->with('kategori')
            ->get();

        $html = '';
        foreach ($berita as $row) {
            $html .= '
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <img class="card-img-top" src="' . route('storage', $row->gambar_berita) . '" alt="' . $row->judul_berita . '" />
                    <div class="card-body p-4">
                        <div class="badge bg-primary bg-gradient rounded-pill mb-2">' . $row->kategori->nama_kategori . '</div>
                        <a class="text-decoration-none link-dark stretched-link" href="' . route('home.detailBerita', $row->slug) . '">
                            <div class="h5 card-title mb-3">' . $row->judul_berita . '</div>
                        </a>
                        <p class="card-text mb-0">' . substr($row->isi_berita, 0, 200) . '</p>
                    </div>
                    <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                        <div class="d-flex align-items-end justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="small">
                                    <div class="fw-bold">Admin</div>
                                    <div class="text-muted">' . $row->created_at->format('d M Y') . '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        return response()->json(['html' => $html]);
    }

    public function kategoriBerita($id)
    {
        $menu = $this->getMenu();
    
        // Cari kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, arahkan ke halaman semua berita
        if (!$kategori) {
            return redirect()->route('home.berita')->with('error', 'Kategori tidak ditemukan');
        }

        // Ambil berita berdasarkan kategori
        $berita = Berita::with('kategori')
            ->where('id_kategori', $id)
            ->latest()
            ->get();

        // Semua kategori untuk sidebar atau navbar
        $semuaKategori = Kategori::all();

        return view('frontend.content.semuaBerita', [
            'menu' => $menu,
            'berita' => $berita,
            'kategori' => $semuaKategori,
            'kategoriTerpilih' => $kategori->nama_kategori,
            'query' => '' // Kosong karena ini filter kategori, bukan pencarian
        ]);
    }

    public function detailBerita($slug)
    {
        //Halaman detail berita
        $menu = $this->getMenu();
        $berita = Berita::with(['kategori', 'user'])->where('slug', $slug)->firstOrFail();
        $kategori = Kategori::all();

        // Untuk post comment
        $comments = Comment::with('pengunjung')->where('id_berita', $berita->id_berita)->get();
        
        //Update total views
        $berita->total_views = $berita->total_views + 1;
        $berita->save();
        return view ('frontend.content.detailBerita', compact('menu', 'berita', 'kategori', 'comments'));
    }

    public function postComment(Request $request, $slug)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        $berita = Berita::where('slug', $slug)->firstOrFail();
        $user = auth('pengunjung')->user() ?? auth('user')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        
        if ($request->filled('id_comment')) {
            $comment = Comment::find($request->id_comment);
            if (!$comment) {
                return response()->json(['error', 'Komentar tidak ditemukan.'], 404);
            }

            $reply = CommentReply::create([
                'id_comment' => $request->id_comment,
                'commentable_id' => $user->id,
                'commentable_type' => get_class($user),
                'reply' => $request->comment,
            ]);

            return response()->json([
                'id' => $comment->id, 
                'user' => [
                    'name' => $user->nama_pengunjung ?? $user->name,
                    'avatar' => $user instanceof \App\Models\Pengunjung
                        ? ($user->foto_profile ? $user->foto_profile : asset('assets/img/default-avatar.png'))
                        : ($user->profile_picture ? asset('storage/'. $user->profile_picture) : asset('assets/img/default-avatar.png')),
                ],
                'reply' => $reply->reply]);
        } else {
            $comment = Comment::create([
                'comment' => $request->comment,
                'commentable_id' => $user->id,
                'commentable_type' => get_class($user),
                'id_berita' => $berita->id_berita,
            ]);

            return response()->json([
                'id' => $comment->id,
                'user' => [
                    'name' => $user->nama_pengunjung ?? $user->name,
                    'avatar' => $user instanceof \App\Models\Pengunjung
                        ? ($user->foto_profile ? $user->foto_profile : asset('assets/img/default-avatar.png'))
                        : ($user->profile_picture ? asset('storage/'. $user->profile_picture) : asset('assets/img/default-avatar.png')),
                ],
                'comment' => $comment->comment]);
        }
    }

    public function detailPage($id)
    {
        $menu = $this->getMenu();
        $page = Page::findOrFail($id);
        return view ('frontend.content.detailPage', compact('menu', 'page'));
    }

    public function semuaBerita(Request $request)
    {
        $menu = $this->getMenu();

        // Ambil parameter kategori dari request
        $kategoriId = $request->input('kategori');

        // Query pencarian berita
        $query = $request->input('search');
        $berita = Berita::with('kategori')
            ->when($kategoriId, function ($q) use ($kategoriId) {
                $q->where('id_kategori', $kategoriId);
            })            
            ->when($query, function ($q) use ($query) {
                $q->where('judul_berita', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();

        $kategori = Kategori::all(); // Untuk menampilkan kategori di navbar atau sidebar
        $kategoriTerpilih = $kategoriId && Kategori::find($kategoriId)
            ? Kategori::find($kategoriId)->nama_kategori
            : 'Kategori';

        return view('frontend.content.semuaBerita', compact('menu', 'berita', 'query', 'kategori', 'kategoriTerpilih'));
    }

    public function likeComment(Request $request, $slug)
    {
        try {
            $user = auth('pengunjung')->user() ?? auth('user')->user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $commentId = $request->input('id_comment');
            if (!$commentId) {
                return response()->json(['error' => 'Invalid comment ID'], 400);
            }

            $comment = Comment::where('id', $commentId)->first();
            if (!$comment) {
                return response()->json(['error' => 'Comment not found'], 404);
            }

            $like = CommentLike::where('id_comment', $comment->id)
                                ->where('commentable_id', $user->id)
                                ->where('commentable_type', get_class($user))
                                ->first();

            if ($like) {
                $like->delete();
                return response()->json(['message' => 'Unliked']);
            } else {
                CommentLike::create([
                    'id_comment' => $comment->id,
                    'commentable_id' => $user->id,
                    'commentable_type' => get_class($user),
                ]);
                return response()->json(['message' => 'Liked']);
            }

            return response()->json([
                'message' => $liked ? 'Liked' : 'Unliked',
                'total_likes' => CommentLike::where('id_comment', $comment->id)->count()
            ]);

        } catch (\Exception $e) {
            Log::error("Error in likeComment: " . $e->getMessage());
            return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
        }
    }

    private function getMenu()
    {
        $menu = Menu::whereNull('parent_menu')
        ->with(['submenu' => fn($q) => $q->where('status_menu', '=', 1)->orderBy('urutan_menu', 'asc')])
        ->where('status_menu', '=', 1)
        ->orderBy('urutan_menu', 'asc')
        ->get();

        $dataMenu = [];
        foreach ($menu as $m) {
            $jenis_menu = $m->jenis_menu;
            $urlMenu = "";

            if ($jenis_menu == "url") {
                $urlMenu = $m->url_menu;
            } else {
                $urlMenu = route('home.detailPage', $m->url_menu);
            }

            //itemMenu
            $dItemMenu = [];
            foreach ($m->submenu as $im) {
                $jenisItemMenu = $im->jenis_menu;
                $urlItemMenu = "";

                if ($jenisItemMenu == "url") {
                    $urlItemMenu = $im->url_menu;
                } else {
                    $urlItemMenu = route('home.detailPage', $im->url_menu);
                }

                $dItemMenu[] = [
                    'sub_menu_nama' => $im->nama_menu,
                    'sub_menu_target' => $im->target_menu,
                    'sub_menu_url' => $urlItemMenu,
                ];
            }
            $dataMenu[] = [
                'menu' => $m->nama_menu,
                'target' => $m->target_menu,
                'url' => $urlMenu,
                'itemMenu' => $dItemMenu,
            ];
        }
        return $dataMenu;
    }
}
