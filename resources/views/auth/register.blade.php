<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Finance Agence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500 min-h-screen flex items-center justify-center">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    
    <div class="relative z-10 w-full max-w-md px-6 py-8">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <i class="fas fa-wallet text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Finance Agence</h1>
            <p class="text-blue-200">Créez votre compte</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                <i class="fas fa-user-plus text-blue-600 mr-2"></i>
                Inscription
            </h2>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mr-2 mt-1"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-5">
                    <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-user text-gray-400 mr-2"></i>Nom complet
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required 
                           autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Votre nom complet">
                </div>

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
                               placeholder="Minimum 8 caractères">
                        <button type="button" 
                                onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Minimum 8 caractères
                    </p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Répétez votre mot de passe">
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer mon compte
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-blue-200 text-sm">
            <p>&copy; {{ date('Y') }} Finance Agence. Tous droits réservés.</p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const iconNumber = fieldId === 'password' ? '1' : '2';
            const toggleIcon = document.getElementById('toggleIcon' + iconNumber);
            
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
