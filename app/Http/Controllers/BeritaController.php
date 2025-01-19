<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with(['kategori', 'user'])->get();
        return view ('backend.content.berita.list', compact('berita'));
    }

    public function tambah()
    {
        $kategori = Kategori::all();
        return view ('backend.content.berita.formTambah', compact('kategori'));
    }

    public function prosesTambah(Request $request)
    {
        $this->validate($request, [
            'judul_berita' => 'required',
            'isi_berita' => 'required',
            'gambar_berita' => 'required',
            'id_kategori' => 'required'
        ]);

        $request->file('gambar_berita')->store('public');
        $gambar_berita = $request->file('gambar_berita')->hashName();

        $berita = new Berita();
        $berita->judul_berita = $request->judul_berita;
        $berita->isi_berita = $request->isi_berita;
        $berita->gambar_berita = $gambar_berita;
        $berita->id_kategori = $request->id_kategori;
        $berita->id_user = auth()->id(); // Menyimpan ID pengguna yang sedang login

        try {
            $berita->save();
            return redirect()->route('berita.index')->with('pesan',['success', 'Berita Berhasil Ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->route('berita.index')->with('pesan',['danger', 'Berita Gagal Ditambahkan']);
        }
    }

    public function ubah($id)
    {
        $berita = Berita::with('user')->findOrFail($id);
        $kategori = Kategori::all();
        // Periksa hak akses: hanya admin atau pemilik berita yang dapat mengubah
        if (auth()->user()->role !== 'admin' && $berita->id_user !== auth()->user()->id) {
            $userName = $berita->user ? $berita->user->name : 'tidak diketahui';
            return redirect()->route('berita.index')->with('pesan', ['danger', "Anda tidak memiliki izin untuk mengubah berita milik {$userName}."]);
        }
        return view ('backend.content.berita.formUbah', compact('berita', 'kategori'));
    }

    public function prosesUbah(Request $request)
    {
        $this->validate($request, [
            'judul_berita' => 'required',
            'isi_berita' => 'required',
            'id_kategori' => 'required'
        ]);

        // Cari berita berdasarkan ID
        $berita = Berita::findOrFail($request->id_berita);

        // Update data berita
        $berita->judul_berita = $request->judul_berita;
        $berita->isi_berita = $request->isi_berita;
        $berita->id_kategori = $request->id_kategori;

        // Jika ada file gambar, proses upload
        if ($request->hasFile('gambar_berita')) {
            $request->file('gambar_berita')->store('public');
            $gambar_berita = $request->file('gambar_berita')->hashName();
            $berita->gambar_berita = $gambar_berita;
        }

        try {
            $berita->save();
            return redirect()->route('berita.index')->with('pesan', ['success', 'Berita Berhasil Diubah']);
        } catch (\Exception $e) {
            return redirect()->route('berita.index')->with('pesan', ['danger', 'Berita Gagal Diubah']);
        }
    }

    public function hapus($id)
    {
        $berita = Berita::with('user')->findOrFail($id);

        // Periksa hak akses: hanya admin atau pemilik berita yang dapat menghapus
        if (auth()->user()->role !== 'admin' && $berita->id_user !== auth()->user()->id) {
            $userName = $berita->user ? $berita->user->name : 'tidak diketahui';
            return redirect()->route('berita.index')->with('pesan', [
                'danger', 
                "Anda tidak memiliki izin untuk menghapus berita milik {$userName}."
            ]);
        }

        try {
            $berita->delete();
            return redirect()->route('berita.index')->with('pesan', ['success', 'Berita Berhasil Dihapus']);
        } catch (\Exception $e) {
            return redirect()->route('berita.index')->with('pesan', ['danger', 'Berita Gagal Dihapus']);
        }
    }
}
