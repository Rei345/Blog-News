<?php

namespace App\Http\Controllers;

use Enception;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('backend.content.user.list', compact('user'));
    }

    public function tambah()
    {
        return view('backend.content.user.formTambah');
    }

    public function prosesTambah(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Membuat pengguna dengan role user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'), // Password default
            'role' => 'user',
        ]);

        return redirect()->route('user.index')->with('pesan', ['success', 'Berhasil tambah user']);
    }

    public function ubah($id)
    {
        $user = User::findOrFail($id);
        return view('backend.content.user.formUbah', compact('user'));
    }

    public function prosesUbah(Request $request)
    {
        $this->validate($request, [
            'id' =>'required',
            'name' =>'required',
            'email' =>'required'
        ]);

        $user = user::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        try {
            $user->save();
            return redirect(route('user.index'))->with('pesan', ['success', 'Berhasil ubah user']);
        } catch (\Exception $e){
            return redirect(route('user.index'))->with('pesan', ['danger', 'Gagal ubah user']);
        }
    }

    public function hapus($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            return redirect(route('user.index'))->with('pesan', ['success', 'Berhasil menghapus user']);
        } catch (\Exception $e){
            return redirect(route('user.index'))->with('pesan', ['danger', 'Gagal menghapus user']);
        }
    }
}
