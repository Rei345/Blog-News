<?php

namespace App\Http\Controllers;

use Enception;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::all();
        return view('backend.content.page.list', compact('page'));
    }

    public function tambah()
    {
        return view('backend.content.page.formTambah');
    }

    public function prosesTambah(Request $request)
    {
        $this->validate($request, [
            'nama_kategori' =>'required'
        ]);

        $page = new page();
        $page->nama_kategori = $request->nama_kategori;

        try {
            $page->save();
            return redirect(route('page.index'))->with('pesan', ['success', 'Berhasil tambah page']);
        } catch (\Exception $e){
            return redirect(route('page.index'))->with('pesan', ['danger', 'Gagal tambah page']);
        }
    }

    public function ubah($id)
    {
        $page = Page::findOrFail($id);
        return view('backend.content.kategori.formUbah', compact('page'));
    }

    public function prosesUbah(Request $request)
    {
        $this->validate($request, [
            'id_kategori' =>'required',
            'nama_kategori' =>'required',
        ]);

        $page = Page::findOrFail($request->id_page);
        $page->nama_kategori = $request->nama_kategori;

        try {
            $page->save();
            return redirect(route('kategori.index'))->with('pesan', ['success', 'Berhasil ubah page']);
        } catch (\Exception $e){
            return redirect(route('kategori.index'))->with('pesan', ['danger', 'Gagal ubah page']);
        }
    }

    public function hapus($id)
    {
        $page = Page::findOrFail($id);

        try {
            $page->delete();
            return redirect(route('page.index'))->with('pesan', ['success', 'Berhasil hapus page']);
        } catch (\Exception $e){
            return redirect(route('page.index'))->with('pesan', ['danger', 'Gagal hapus page']);
        }
    }

}
