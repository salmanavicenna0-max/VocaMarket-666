<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status == 'pending') {
            $query->where('seller_status', 'pending');
        }

        $users = $query->latest()->get();

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
            'nis' => 'required|string|max:12|unique:users,nis',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,siswa,pembeli',
            'email_verification' => 'nullable|string',
            'verification_seller' => 'nullable|boolean',
        ]);

        $validated['email_verification'] = $request->input('email_verification', 'verified');
        $validated['verification_seller'] = $request->has('verification_seller') ? 1 : 0;

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
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
            'nis' => 'required|string|max:12|unique:users,nis,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,siswa,pembeli',
            'verification_seller' => 'nullable|boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $validated['password'] = $request->password;
        }

        $validated['verification_seller'] = $request->has('verification_seller') ? 1 : 0;

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
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
