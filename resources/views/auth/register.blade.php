<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Voca Market 666</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {

                    colors: {
                        primary: '#3B82F6',
                        accent: '#ffb900',
                        body: '#E3E6E6',
                        blue: {
                            50: '#eef8ff',
                            100: '#d9efff',
                            200: '#bce4ff',
                            300: '#8ed4ff',
                            400: '#59bcff',
                            500: '#32a2ff',
                            600: '#3B82F6',
                            700: '#0267ad',
                            800: '#06578e',
                            900: '#0b4875',
                        },
                        yellow: {
                            50: '#fffdf2',
                            100: '#fff8db',
                            200: '#fff0b0',
                            300: '#ffe580',
                            400: '#ffd64d',
                            500: '#ffb900',
                            600: '#d99c00',
                            700: '#ad7c00',
                            800: '#805c00',
                            900: '#523a00',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-body antialiased min-h-screen flex items-center justify-center font-sans py-10">

    <!-- Register Container -->
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl overflow-hidden p-8 border border-gray-100">

        <!-- Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-90 transition">
                <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-24 w-auto mx-auto object-contain">
            </a>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Buat Akun Baru</p>
        </div>

        <!-- Form -->
        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Role (hidden) -->
            @php($role = request('role', 'pembeli'))
            <input type="hidden" name="role" value="{{ in_array($role, ['admin','siswa','pembeli']) ? $role : 'pembeli' }}">

            @error('register')
                <div class="mb-3 rounded-md bg-red-50 p-3 text-sm text-red-700">{{ $message }}</div>
            @enderror

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Masukkan Nama Lengkap"
                    value="{{ old('name') }}"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-md px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >

                @error('name')
                    <p class="text-xs text-red-600 mt-1 font-medium">Nama tidak valid</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan Email Aktif"
                    value="{{ old('email') }}"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-md px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >
                @error('email')
                    <p class="text-xs text-red-600 mt-1 font-medium">Email tidak valid atau sudah digunakan</p>
                @enderror
            </div>



            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Buat Password Minimal 6 Karakter"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-md px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >
                @error('password')
                    <p class="text-xs text-red-600 mt-1 font-medium">Password minimal 6 karakter</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi Password"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-md px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >
                @error('password_confirmation')
                    <p class="text-xs text-red-600 mt-1 font-medium">Password tidak sesuai</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                >
                    Daftar Akun
                </button>
            </div>

        </form>

        <!-- Footer -->
        <div class="mt-8 text-center border-t border-gray-100 pt-6 flex flex-col items-center gap-4">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-blue-800 transition">Masuk di sini</a>
            </p>
            <a href="{{ url('/') }}" class="inline-block text-xs font-bold text-gray-500 hover:text-primary transition">
                Kembali ke Halaman Utama
            </a>
        </div>


    </div>

</body>
</html>
