<section>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="text-warning mt-2">
                    Votre adresse email n'est pas vérifiée. <button form="send-verification" class="btn btn-link">Cliquez ici pour renvoyer l'email de vérification</button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="text-success mt-2">Un nouveau lien de vérification a été envoyé.</p>
                @endif
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Sauvegarder</button>
    </form>
</section>
