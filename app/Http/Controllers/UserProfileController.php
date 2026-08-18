<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\Review;
use App\Models\Profile;

class UserProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna (Biodata, Transaksi, Ulasan, Pengaturan, Buka Toko)
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        // Ambil transaksi (sebagai pembeli)
        $orders = Order::where('user_id', $user->id)->with('items.product')->latest()->get();
        
        // Ambil ulasan yang pernah dibuat
        $reviews = Review::where('user_id', $user->id)->with('product')->latest()->get();

        return view('profile.user', compact('user', 'profile', 'orders', 'reviews'));
    }

    /**
     * Perbarui Biodata Diri
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'tanggal_lahir_tgl' => 'nullable|integer',
            'tanggal_lahir_bln' => 'nullable|string',
            'tanggal_lahir_thn' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        // Update nama user
        $user->name = $validated['name'];
        $user->save();

        // Siapkan tanggal lahir jika ada
        $tanggal_lahir = null;
        if (!empty($validated['tanggal_lahir_tgl']) && !empty($validated['tanggal_lahir_bln']) && !empty($validated['tanggal_lahir_thn'])) {
            $months = [
                'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04', 
                'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08', 
                'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12'
            ];
            $month = $months[$validated['tanggal_lahir_bln']] ?? '01';
            $tanggal_lahir = sprintf('%04d-%02d-%02d', $validated['tanggal_lahir_thn'], $month, $validated['tanggal_lahir_tgl']);
        }

        // Update atau buat profile
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'no_telp' => $validated['no_telp'],
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            ]
        );

        return back()->with('success', 'Biodata diri berhasil diperbarui.');
    }

    /**
     * Perbarui Kata Sandi
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        $user->password = Hash::make($validated['new_password']); // Note: In Laravel 10+ with cast 'hashed', assigning the string works, but let's be safe. Wait, since User model casts 'password' => 'hashed', we just assign the raw string.
        $user->password = $validated['new_password']; // It will be hashed automatically by the cast.
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    /**
     * Perbarui Foto Profil
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $user = Auth::user();
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $profile->photo = $path;
            $profile->foto = $path;
            $profile->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}
