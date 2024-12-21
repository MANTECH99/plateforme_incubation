<!-- create_session_coach.blade.php dans views -->
@extends('layouts.app')

@section('title', 'Créer une Séance de Mentorat')

@section('content')
    <h1>Détails de la Tâche</h1>

    <div>
        <p><strong>Nom de la Tâche :</strong> {{ $task->title }}</p>
        <p><strong>Description :</strong> {{ $task->description }}</p>
        <p><strong>Échéance :</strong> {{ $task->due_date->format('d/m/Y') }}</p>
        <p><strong>Statut :</strong> {{ $task->status }}</p>
        <p><strong>Projet :</strong> {{ $task->project->title }}</p>
    </div>

    <a href="{{ route('coach.projects.show', $task->project_id) }}">Retour au Projet</a>
    @endsection
