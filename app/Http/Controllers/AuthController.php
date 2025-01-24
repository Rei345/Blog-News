<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login di tabel users (untuk role admin dan user)
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard.index'); 
        }

        // Jika tidak ditemukan di tabel users, cek di tabel pengunjung
        $pengunjung = Pengunjung::where('email', $request->email)->first();

        if ($pengunjung && Hash::check($request->password, $pengunjung->password)) {
            // Jika ditemukan di tabel pengunjung dan password cocok
            Auth::guard('pengunjung')->login($pengunjung);
            return redirect()->route('home.index'); 
        }

        // Jika email dan password tidak valid
        return redirect(route('auth.index'))->with('pesan', ['danger', 'Kombinasi email dan password salah']);
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_pengunjung' => 'required|string|max:255',
            'email' => 'required|email|unique:pengunjung,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Membuat pengguna tanpa role khusus
        $pengunjung = Pengunjung::create([
            'nama_pengunjung' => $request->nama_pengunjung,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profile' => asset('assets/img/undraw_profile_1.svg'),
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('auth.index')->with('pesan', ['success', 'Akun berhasil dibuat. Silahkan login!']);
    }

    public function logout()
    {
        // Periksa apakah pengguna login sebagai 'user'
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect()->route('auth.index')->with('pesan', ['success', 'Anda berhasil logout sebagai admin/user.']);
        }

        // Periksa apakah pengguna login sebagai 'pengunjung'
        if (Auth::guard('pengunjung')->check()) {
            Auth::guard('pengunjung')->logout();
            return redirect()->route('auth.index')->with('pesan', ['success', 'Anda berhasil logout sebagai pengunjung.']);
        }

        return redirect()->route('auth.index')->with('pesan', ['warning', 'Tidak ada sesi login yang ditemukan.']);
    }

    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->registerOrLogin($user, 'google');
        return redirect()->route('home.index');
    }

    //redirect to Facebook 
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //Handle Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->registerOrLogin($user, 'facebook');
        return redirect()->route('home.index');
    }

    // Common Registration/Login
    private function registerOrLogin($socialUser, $provider)
    {
        $pengunjung = Pengunjung::where('email', $socialUser->getEmail())->first();

        if (!$pengunjung) {
            $pengunjung - Pengunjung::class([
                'nama_pengunjung' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'foto_profile' => $socialUser->getAvatar(),
                'provider' => $provider,
                'id_provider' => $socialUser->getId(),
            ]);
        }

        auth('pengunjung')->login($pengunjung);
    }
}
