@extends('layouts.app')

@section('title', 'Assigner un Coach à un Projet')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <!-- row -->
    <!-- Container Fluid-->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Assigner un Coach à un Projet</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Formulaire d'assignation de coach -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center" style="background-color: #27ae60 ; color: white;">
                        <h6 class="m-0 font-weight-bold" style="color: white;">Formulaire de mise en relation</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.assign-coach') }}">
                            @csrf
                            <div class="form-group d-flex justify-content-center">
                                <label for="project_id" class="mr-3">Projet :</label>
                                <select name="project_id" id="project_id" class="form-control" style="width: 50%;" required>
                                    <option value="">Sélectionnez un projet</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-4 d-flex justify-content-center">
                                <label for="coach_id" class="mr-3">Coach :</label>
                                <select name="coach_id" id="coach_id" class="form-control" style="width: 50%;" required>
                                    <option value="">Sélectionnez un coach</option>
                                    @foreach($coaches as $coach)
                                        <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-4 d-flex justify-content-center">
                                <button type="submit" class="btn btn-md" style="background-color: #27ae60     ; color: white;">Assigner le Coach</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
Content body end
***********************************-->
@endsection

