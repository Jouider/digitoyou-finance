<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Finance Agence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500 min-h-screen flex items-center justify-center">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    
    <div class="relative z-10 w-full max-w-md px-6">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <i class="fas fa-wallet text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Finance Agence</h1>
            <p class="text-blue-200">Gestion financière digitale</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                <i class="fas fa-sign-in-alt text-blue-600 mr-2"></i>
                Connexion
            </h2>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required 
                           autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="votre@email.com">
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>Mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="••••••••">
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-blue-200 text-sm">
            <p>&copy; {{ date('Y') }} Finance Agence. Tous droits réservés.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
