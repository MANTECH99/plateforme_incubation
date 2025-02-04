@extends('layouts.app')

@section('title', 'Profil Utilisateur')

@section('content')

    <!-- Ajouter les liens vers les fichiers CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('src/plugins/jquery-steps/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">

    <!-- Si vous utilisez Vite, vous pouvez ajouter cette ligne pour charger les assets -->
    @vite('resources/css/app.css')


    <div class="main-container" style="width: 100%; margin: 0; padding: 0;">x_

        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix">
                        <h4 class="text-blue h4">Modifier votre profil</h4>
                        <p class="mb-30">Mettez à jour vos informations personnelles, votre projet, et plus.</p>
                    </div>
                    <div class="wizard-content">
                        <form id="profile-update-form" class="tab-wizard wizard-circle wizard" action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            <h5>Informations personnelles</h5>
                            <section>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fonction :</label>
                                            <input type="text" class="form-control" name="fonction" value="{{ old('fonction', $user->fonction) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Genre :</label>
                                            <div class="form-control d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="genre" id="homme" value="Homme" {{ $user->genre == 'Homme' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="homme">Homme</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="genre" id="femme" value="Femme" {{ $user->genre == 'Femme' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="femme">Femme</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Biographie :</label>
                                            <input type="text" class="form-control" name="biographie" value="{{ old('biographie', $user->biographie) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Téléphone :</label>
                                            <input type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ville de résidence :</label>
                                            <select class="custom-select form-control" name="ville">
                                                <option value="Thiés" {{ $user->ville == 'Thiés' ? 'selected' : '' }}>Thiés</option>
                                                <option value="Dakar" {{ $user->ville == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                                                <option value="Tivaouane" {{ $user->ville == 'Tivaouane' ? 'selected' : '' }}>Tivaouane</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date de naissance :</label>
                                            <input type="date" class="form-control" name="date_naissance" value="{{ old('date_naissance', $user->date_naissance) }}">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h5>Vos réseaux sociaux</h5>
                            <section>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Instagram :</label>
                                            <input type="text" class="form-control" name="instagram" value="{{ old('instagram', $user->instagram) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Facebook :</label>
                                            <input type="text" class="form-control" name="facebook" value="{{ old('facebook', $user->facebook) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Linkedin :</label>
                                            <input type="text" class="form-control" name="linkedin" value="{{ old('linkedin', $user->linkedin) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Twitter :</label>
                                            <input type="text" class="form-control" name="twitter" value="{{ old('twitter', $user->twitter) }}">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h5>Votre projet</h5>
                            <section>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nom du Startup :</label>
                                            <input type="text" class="form-control" name="startup_nom" value="{{ old('startup_nom', $user->startup_nom) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Slogan du startup :</label>
                                            <input type="text" class="form-control" name="startup_slogan" value="{{ old('startup_slogan', $user->startup_slogan) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Domaine d'expertise:</label>
                                            <textarea class="form-control" name="expertise">{{ old('expertise', $user->expertise) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Adresse du startup :</label>
                                            <input type="text" class="form-control" name="startup_adresse" value="{{ old('startup_adresse', $user->startup_adresse) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Secteur d'activité :</label>
                                            <input class="form-control" type="text" name="startup_secteur" value="{{ old('startup_secteur', $user->startup_secteur) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Experience :</label>
                                            <textarea class="form-control" name="experience">{{ old('experience', $user->experience) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <h5>Votre pitch</h5>
                            <section>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Votre pitch :</label>
                                            <textarea class="form-control" name="pitch">{{ old('pitch', $user->pitch) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Votre photo de profil :</label>
                                            <input type="file" class="form-control" name="profile_picture" accept="image/*">
                                            @if($user->profile_picture)
                                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Profil" style="max-width: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center font-18">
                                <h3 class="mb-20">Profil Mise à jour !</h3>
                                <div class="d-flex justify-content-center mb-30">
                                    <img src="{{ asset('vendors/images/success.png') }}" alt="Succès" class="img-fluid" style="max-width: 150px;">
                                </div>
                                Veuillez consultez votre profil pour plus d'informations
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <!-- Ajouter les scripts JS à la fin du fichier -->
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('src/plugins/jquery-steps/jquery.steps.js') }}"></script>
    <script src="{{ asset('vendors/scripts/steps-setting.js') }}"></script>


    <!-- Si vous utilisez Vite, vous pouvez ajouter cette ligne pour charger les scripts -->
    @vite('resources/js/app.js')
@endsection
