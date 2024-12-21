<!-- create_session_coach.blade.php dans views -->
@extends('layouts.app')

@section('title', 'Créer une Séance de Mentorat')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Créer une Séance de Mentorat</a></li>
            </ol>
        </div>
    </div>
    <!-- Container Fluid -->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Créer une Séance de Mentorat</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('mentorship_sessions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="project_id">Projet :</label>
                                <select name="project_id" id="project_id" class="form-control" required>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="start_time">Date et heure de début :</label>
                                <input 
                                    type="datetime-local" 
                                    name="start_time" 
                                    id="start_time" 
                                    class="form-control"
                                    value="{{ request('start') ? date('Y-m-d\TH:i', strtotime(request('start'))) : '' }}" 
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="end_time">Date et heure de fin :</label>
                                <input 
                                    type="datetime-local" 
                                    name="end_time" 
                                    id="end_time" 
                                    class="form-control"
                                    value="{{ request('end') ? date('Y-m-d\TH:i', strtotime(request('end'))) : '' }}" 
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes de session :</label>
                                <textarea name="notes" id="notes" rows="4" class="form-control">{{ $session->notes ?? '' }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Créer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
@endsection
