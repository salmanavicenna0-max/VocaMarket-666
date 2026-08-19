<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Voca Market 666</title>
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
<body class="bg-body antialiased min-h-screen flex items-center justify-center font-sans">

    <!-- Login Container -->
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl overflow-hidden p-8 border border-gray-100">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-90 transition">
                <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-24 w-auto mx-auto object-contain">
            </a>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Selamat Datang Kembali</p>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-3 rounded-md text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <!-- Email -->
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan Email"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-md px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >
            </div>

            <!-- Password Section -->
            <div>
                <!-- Password Input -->
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan Password"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-md px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-3">
                    <div class="flex items-center">
                        <input 
                            id="remember-me" 
                            name="remember-me" 
                            type="checkbox" 
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded-sm cursor-pointer"
                        >
                        <label for="remember-me" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                            Ingat Saya
                        </label>
                    </div>
                    <a href="#" class="text-xs font-semibold text-primary hover:text-blue-800 transition">Lupa password?</a>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                >
                    Masuk
                </button>
            </div>
            
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center border-t border-gray-100 pt-6 flex flex-col items-center gap-4">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-primary hover:text-blue-800 transition">Daftar Sekarang</a>
            </p>
            <a href="{{ url('/') }}" class="inline-block text-xs font-bold text-gray-500 hover:text-primary transition">
                Kembali ke Halaman Utama
            </a>
            <p class="text-[10px] text-gray-400 mt-2">
                Platform Kewirausahaan Siswa &bull; PPLG | DKV | Animasi | Akuntansi | Pemasaran
            </p>
        </div>

    </div>

</body>
</html>
