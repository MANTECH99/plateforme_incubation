<!-- create_session_coach.blade.php dans views -->
@extends('layouts.app')

@section('title', 'Créer une Séance de Mentorat')

@section('content')
    <h1>Détails de la Séance de Mentorat</h1>

    <div>
        <p><strong>Projet :</strong> {{ $session->project->title }}</p>
        <p><strong>Coach :</strong> {{ $session->coach->name }}</p>
        <p><strong>Date et Heure de Début :</strong> {{ $session->start_time->format('d/m/Y H:i') }}</p>
        <p><strong>Date et Heure de Fin :</strong> {{ $session->end_time->format('d/m/Y H:i') }}</p>
    </div>

    <a href="{{ route('mentorship_sessions.index') }}">Retour aux Séances</a>
    @endsection
