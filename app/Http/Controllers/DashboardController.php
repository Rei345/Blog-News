<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kategori;
use App\Models\Berita;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBerita = Berita::count();
        $totalKategori = Kategori::count();
        $totalUser = User::Count();
        $lastestBerita = Berita::with('kategori')->latest()->get()->take(5);
        return view('backend.content.dashboard', compact('totalBerita', 'totalKategori', 'totalUser', 'lastestBerita'));
    }

    public function profile()
    {
        $id = Auth::guard('user')->user()->id;
        $user = User::findOrFail($id);
        return view('backend.content.profile', compact('user'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $id = Auth::guard('user')->user()->id;
        $user = User::findOrFail($id);

        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture))) {
                unlink(storage_path('app/public/' . $user->profile_picture));
            }

            // Upload foto baru
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');

            // Simpan path ke database
            $user->profile_picture = $path;
            $user->save();

            return redirect()->route('dashboard.profile')->with('pesan', ['success', 'Foto profil berhasil diupdate!']);
        }

        return redirect()->route('dashboard.profile')->with('pesan', ['danger', 'Gagal mengupload foto profil.']);
    }

    public function resetPassword()
    {
        return view('backend.content.resetPassword');
    }

    public function prosesResetPassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'c_new_password' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $id = Auth::guard('user')->user()->id;
        $user = User::findOrFail($id);

        if (Hash::check($old_password, $user->password)) {
            $user->password = bcrypt($new_password);

            try {
                $user->save();
                return redirect(route('dashboard.resetPassword'))->with('pesan', ['success', 'Password Berhasil Diubah']);
            } catch (\Exception $e) {
                return redirect()->route('dashboard.resetPassword')->with('pesan', ['danger', 'Password Gagal Diubah']);
            }
        } else {
            return redirect()->route('dashboard.resetPassword')->with('pesan', ['danger', 'Password Lama Salah']);
        }
    }
}
