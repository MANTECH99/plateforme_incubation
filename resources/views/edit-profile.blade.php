<!-- edit_coach_profile.blade.php dans views -->
@extends('layouts.app')

@section('title', 'Modifier le Profil du Coach')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <!-- row -->
    <!-- Container Fluid-->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Modifier le Profil du Coach</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Formulaire de modification du profil -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Informations du Coach</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('coach.profile.update', $coach->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="bio">Biographie :</label>
                                <textarea name="bio" id="bio" class="form-control" rows="5">{{ $coach->bio }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="expertise">Domaines d'expertise :</label>
                                <input type="text" name="expertise" id="expertise" class="form-control" value="{{ $coach->expertise }}">
                            </div>
                            <div class="form-group">
                                <label for="experience">Expérience :</label>
                                <input type="text" name="experience" id="experience" class="form-control" value="{{ $coach->experience }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
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
