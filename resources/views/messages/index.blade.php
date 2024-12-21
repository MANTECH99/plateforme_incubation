<!-- index.blade.php dans views -->
@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <h1>Messagerie</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Onglets -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#received" data-bs-toggle="tab" role="tab">Messages Reçus</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#sent" data-bs-toggle="tab" role="tab">Messages Envoyés</a>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="received" role="tabpanel">
            <h2>Messages Reçus</h2>
            @if($receivedMessages->isEmpty())
                <p>Aucun message reçu.</p>
            @else
                <ul>
                    @foreach($receivedMessages as $message)
                        <li>
                            <strong>De :</strong> {{ $message->sender->name }}<br>
                            <p>{{ $message->content }}</p>
                            <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
                        </li>
                    @endforeach
                </ul>
                {{ $receivedMessages->links() }}
            @endif
        </div>

        <div class="tab-pane fade" id="sent" role="tabpanel">
            <h2>Messages Envoyés</h2>
            @if($sentMessages->isEmpty())
                <p>Aucun message envoyé.</p>
            @else
                <ul>
                    @foreach($sentMessages as $message)
                        <li>
                            <strong>À :</strong> {{ $message->receiver->name }}<br>
                            <p>{{ $message->content }}</p>
                            <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
                        </li>
                    @endforeach
                </ul>
                {{ $sentMessages->links() }}
            @endif
        </div>
    </div>

    <form method="POST" action="{{ route('messages.send') }}">
        @csrf
        <div>
            <label for="receiver_id">Destinataire :</label>
            <select name="receiver_id" id="receiver_id" required>
                <option value="">Sélectionnez un destinataire</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <textarea name="content" id="content" placeholder="Votre message" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
