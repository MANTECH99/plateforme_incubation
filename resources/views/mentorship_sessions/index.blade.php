@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')

<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <!-- Breadcrumb -->
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>


        <!-- Table des Séances de Mentorat -->
        <div class="col-12 mt-5">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #3498db; color: white;">
                <h4 class="m-0 font-weight-bold">Séances de Mentorat</h4>
            </div>
            <div class="card-body">
            @if(auth()->user()->role->name == 'coach')
                <a href="{{ route('google.redirect') }}" class="btn btn-success mb-3"> <i class="fa fa-plus-circle"></i> Se connecter avec Google pour créer une séance</a>
            @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead style="background-color: #3498db; color: white;">
                            <tr>
                                <th style="border: 1px solid #2ecc71;">Projet</th>
                                <th style="border: 1px solid #2ecc71;">Coach</th>
                                <th style="border: 1px solid #2ecc71;">Date de début</th>
                                <th style="border: 1px solid #2ecc71;">Date de fin</th>
                                <th style="border: 1px solid #2ecc71;">Notes</th>
                                <th style="border: 1px solid #2ecc71;">Lien de la réunion</th>
                                <th style="border: 1px solid #2ecc71;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td>{{ $session->project->title }}</td>
                                    <td>{{ $session->coach->name }}</td>
                                    <td>{{ $session->start_time}}</td>
                                    <td>{{ $session->end_time}}</td>
                                    <td>{{ $session->notes ?? 'Aucune note' }}</td>
                                    <td>
    @if($session->meeting_link)
        <a href="{{ $session->meeting_link }}" target="_blank">Rejoindre la réunion</a>
    @else
        Non défini
    @endif
</td>
                                    <td>
                                    
                                        @if(auth()->user()->role->name === 'coach')
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-secondary"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('mentorship_sessions.destroy', $session->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Total des séances : <span class="font-weight-bold">{{ $sessions->count() }}</span></p>
                </div>
    <!-- Calendrier des Séances -->
    <div class="col-12 mt-5">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #3498db; color: white;">
                <h4 class="m-0 font-weight-bold">Calendrier des Séances de Mentorat</h4>
            </div>
            <div class="card-body">
                <div id="calendar" style="margin-bottom: 30px;"></div>
            </div>
        </div>
    </div>


            </div>
        </div>
    </div>

</div>

<!-- JS spécifique -->
@vite('resources/js/mentorship_calendar.js')

@endsection
