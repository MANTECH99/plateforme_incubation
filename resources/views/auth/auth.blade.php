<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <title>Modern Login and Register Page | AsmrProg</title>
</head>

<body>
<div class="logo">
                <img src="{{ asset('images/logo-d.png') }}" alt="Logo">
            </div>
    <div class="container" id="container">
        <!-- Register Form -->
        <div class="form-container sign-up">

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Créer un compte</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <div class="input-container">
    <i class="fa-solid fa-user"></i>
    <input type="text" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus autocomplete="name">
</div>
<x-input-error :messages="$errors->get('name')" class="mt-2" />

<div class="input-container">
    <i class="fa-solid fa-envelope"></i>
    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
</div>
<x-input-error :messages="$errors->get('email')" class="mt-2" />

<div class="input-container">
    <i class="fa-solid fa-lock"></i>
    <input type="password" id="password" name="password" placeholder="Password" required autocomplete="new-password">
</div>
<x-input-error :messages="$errors->get('password')" class="mt-2" />

<div class="input-container">
    <i class="fa-solid fa-lock"></i>
    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
</div>
<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <!-- Role Selection with Radio Buttons -->
        <div class="select-role">
            <div class="role-options">
                <label class="role-option">
                    <input type="radio" name="role_id" value="2" required>
                    <div class="icon"><i class="fa fa-user-tie"></i></div>
                    <span>Porteur</span>
                </label>
                <label class="role-option">
                    <input type="radio" name="role_id" value="3" required>
                    <div class="icon"><i class="fa fa-chalkboard-teacher"></i></div>
                    <span>Coach</span>
                </label>
            </div>
        </div>
        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />

                <button type="submit">S'INSCRIRE</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Se connecter</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <div class="input-container">
    <i class="fa-solid fa-envelope"></i>
    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
</div>
<x-input-error :messages="$errors->get('email')" class="mt-2" />

<div class="input-container">
    <i class="fa-solid fa-lock"></i>
    <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
</div>
<x-input-error :messages="$errors->get('password')" class="mt-2" />

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Souviens-toi de moi') }}</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                @endif
                <button type="submit">SE CONNECTER</button>
            </form>
        </div>

        <!-- Toggle between Login and Register -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                <div class="logos">
                <img src="{{ asset('images/uasz.png') }}" alt="Logo">
            </div>
                    <h1>Content de te revoir !</h1>
                    <p>Entrez vos informations personnelles pour utiliser toutes les fonctionnalités du site</p>
                    <button class="hidden" id="login">SE CONNECTER</button>
                </div>
                <div class="toggle-panel toggle-right">
                <div class="logos">
                <img src="{{ asset('images/uasz.png') }}" alt="Logo">
            </div>
                    <h1>Bonjour mon ami !</h1>
                    <p>Inscrivez-vous avec vos données personnelles pour utiliser toutes les fonctionnalités du site</p>
                    <button class="hidden" id="register">S'INSCRIRE</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('script.js') }}"></script>
</body>

</html>
