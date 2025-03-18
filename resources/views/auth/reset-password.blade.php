<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <title>Réinitialisation du mot de passe</title>
</head>

<body>
<div class="logo">
    <img src="{{ asset('images/logo-d.png') }}" alt="Logo">
</div>
<div class="container" id="container">

    <!-- Password Reset Form -->
    <div class="form-container sign-in">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <h1>Réinitialisation du mot de passe</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            
            <div class="input-container">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email', $request->email) }}" required autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Nouveau mot de passe" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            
            <div class="input-container">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmer le mot de passe" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            
            <button type="submit">Réinitialiser</button>
        </form>
    </div>

    <!-- Information Panel -->
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-right">
                <div class="logos">
                    <img src="{{ asset('images/uasz.png') }}" alt="Logo">
                </div>
                <h1>Cher Utilisateur !</h1>
                <p>Entrez votre nouveau mot de passe pour sécuriser votre compte.</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('script.js') }}"></script>
</body>

</html>
