<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nis' => ['nullable', 'integer', 'max:12', 'unique:users,nis'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,siswa,pembeli'],
        ]);

        User::create([
            'name' => $validated['name'],
            'nis' => $validated['nis'] ?? null,
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'verification_seller' => 'no',
            'verification_seller_at' => null,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('profile', 'jurusan');
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('profile');
        $jurusan = Jurusan::where('is_active', 'true')->get();

        return view('admin.user.edit', compact('user', 'jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users.email' . $user->id],
            'jurusan_id' => ['nullable', 'exist:jurusan_id'],
            'role' => ['required', 'in:admin,siswa,pembeli'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nis' => ['nullable', 'string', 'max:12']
        ]);

        $data = collect($validated)->except(['password', 'nis'])->array();
        if (! empty($validated['password'])) {
                $data['password'] = $validated['password'];
        }

        $user->update($data);
        $user->profile()->updateOrCreate([], ['nis' => $validated['nis'] ?? null]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
