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
                        primary: '#007DCC',
                        accent: '#FFB900', 
                        body: '#E3E6E6'   
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-body antialiased min-h-screen flex items-center justify-center font-sans">

    <!-- Login Container -->
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden p-8 border border-gray-100">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-90 transition">
                <h1 class="font-bold text-3xl text-primary tracking-tight mb-1">
                    Voca Market <span class="text-accent">666</span>
                </h1>
            </a>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">SMK Bakti Nusantara</p>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-3 rounded-lg text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <!-- Email / NIS -->
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Email atau NIS</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan Email atau NIS"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-lg px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <a href="#" class="text-xs font-semibold text-primary hover:text-blue-800 transition">Lupa password?</a>
                </div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan Password"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-lg px-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                    required
                >
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    id="remember-me" 
                    name="remember-me" 
                    type="checkbox" 
                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer"
                >
                <label for="remember-me" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                    Ingat Saya
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition"
                >
                    Masuk
                </button>
            </div>
            
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="#" class="font-bold text-primary hover:text-blue-800 transition">Daftar Sekarang</a>
            </p>
            <p class="text-[10px] text-gray-400 mt-4">
                Platform Kewirausahaan Siswa &bull; PPLG | DKV | Animasi | Akuntansi | Pemasaran
            </p>
        </div>

    </div>

</body>
</html>
