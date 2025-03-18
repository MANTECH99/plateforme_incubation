

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

    <!-- Login Form -->
    <div class="form-container sign-in">
    <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <h1>Réinitialisation du mot de passe</h1><br>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div><br>
            <div class="input-container">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="username">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" /><br>
            <button type="submit">Envoyer le lien</button>
        </form>
    </div>

    <!-- Toggle between Login and Register -->
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-right">
                <div class="logos">
                    <img src="{{ asset('images/uasz.png') }}" alt="Logo">
                </div>
                <h1>Cher Utilisateur !</h1>
                <p>Entrez votre adresse e-mail et nous vous enverrons un lien de réinitialisation.</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('script.js') }}"></script>
</body>

</html>

