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
                <input type="text" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <input type="password" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                <div class="select-container">
    <select name="role_id" id="role" required>
        <option value=""> Sélectionnez un rôle </option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>

</div>
<x-input-error :messages="$errors->get('role_id')" class="mt-2" />


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
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
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
                    <h1>Content de te revoir !</h1>
                    <p>Entrez vos informations personnelles pour utiliser toutes les fonctionnalités du site</p>
                    <button class="hidden" id="login">SE CONNECTER</button>
                </div>
                <div class="toggle-panel toggle-right">
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
