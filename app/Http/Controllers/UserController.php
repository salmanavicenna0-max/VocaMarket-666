<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status == 'pending') {
            $query->where('seller_status', 'pending');
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('Admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,siswa,pembeli',
            'verification_seller' => 'nullable|boolean',
        ]);

        $validated['verification_seller'] = $request->has('verification_seller') ? 1 : 0;
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('Admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('Admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,siswa,pembeli',
            'password' => 'nullable|string|min:6',
            'verification_seller' => 'nullable|boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['verification_seller'] = $request->has('verification_seller') ? 1 : 0;

        $user->update($validated);

        return back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Handle a user's request to become a seller.
     */
    public function requestSeller(Request $request)
    {
        $user = Auth::user();

        // Cek jika statusnya masih none atau rejected
        if ($user->seller_status === 'none' || $user->seller_status === 'rejected') {
            $user->seller_status = 'pending';
            $user->save();
            return back()->with('success', 'Permintaan buka toko berhasil dikirim! Menunggu verifikasi admin.');
        }

        return back()->with('error', 'Permintaan sudah diproses atau toko Anda sudah aktif.');
    }

    /**
     * Handle admin approving a seller request.
     */
    public function approveSeller(User $user)
    {
        $user->seller_status = 'approved';
        $user->verification_seller = 1;
        // Opsional: ganti role menjadi penjual atau tetap siswa
        // $user->role = 'penjual';
        $user->save();

        return back()->with('success', 'Toko milik ' . $user->name . ' berhasil disetujui!');
    }
}
