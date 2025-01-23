@extends('layouts.app')

@section('title', 'Profil Utilisateur')

@section('content')

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('src/plugins/cropperjs/dist/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">


    <div class="main-container" style="width: 100%; margin: 0; padding: 0;">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="row">
                    <!-- Colonne de gauche pour la photo et les informations de profil -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                        <div class="profile-photo">
    <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Photo de profil" class="avatar-photo">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-body pd-5">
												<div class="img-container">
													<img id="image" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Picture">
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" value="Update" class="btn btn-primary">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>

                            <h5 class="text-center h5 mb-0">{{ $user->name }}</h5> <!-- Affichage du nom -->
                            <p class="text-center text-muted font-14">{{ $user->role->description }}</p>

                            <div class="profile-info">
                                <h5 class="mb-20 h5 text-blue">Biographie</h5>
                                <ul>
                                    <li>{{ $user->biographie }}</li> <!-- Biographie de l'utilisateur -->
                                </ul><br>
                                <ul>
                                    <li>
                                    <h5 class="mb-20 h5 text-blue">Adresse Email:</h5>
                                        {{ $user->email }}
                                    </li>
                                    <li>
                                    <h5 class="mb-20 h5 text-blue">Numéro téléphone:</h5>
                                        {{ $user->telephone }}
                                    </li>
                                    <li>
                                    <h5 class="mb-20 h5 text-blue">Région:</h5>
                                        {{ $user->ville }}
                                    </li>
                                    <li>
                                    <h5 class="mb-20 h5 text-blue">Adresse:</h5>
                                        {{ $user->startup_adresse }}
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Colonne de droite pour la section Timeline et les paramètres -->
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist" style="background-color: #27ae60;">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab" style= "color: white;">Timeline</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#setting" role="tab" style="color: white;">Modifier mes infos personnels</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
										<!-- Timeline Tab start -->
										<div class="tab-pane fade show active" id="timeline" role="tabpanel">
											<div class="pd-20">
												<div class="profile-timeline">
													<div class="profile-timeline-list">
														<ul>
															<li>
                                                            <div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>

																<div class="task-name"> Domaine d'expertise</div>
																<p>{{ $user->expertise }}</p>
																
															</li>
															<li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name"> Expérience</div>
																<p>{{ $user->experience }}</p>
															</li>
															<li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name"> Nom du startup</div>
																<p>{{ $user->startup_nom }}</p>
																
															</li>
															<li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name"> Slogan du startup</div>
																<p>{{ $user->startup_slogan }}</p>
																
															</li>
                                                            <li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name"> Adresse du startup</div>
																<p>{{ $user->startup_adresse }}</p>
																
															</li>
                                                            <li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name"> Mon pitch</div>
																<p>{{ $user->pitch }}</p>
																
															</li>
														</ul>
													</div><br>
                                                    <div class="profile-social">
								<h5 class="mb-20 h5 text-blue">Réseaux Sociaux</h5>
								<ul class="clearfix">
									<li><a href="{{ $user->facebook }}" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"><i class="fa fa-facebook"></i></a></li>
									<li><a href="{{ $user->twitter }}" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"><i class="fa fa-twitter"></i></a></li>
									<li><a href="{{ $user->linkedin }}" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="{{ $user->instagram }}" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>

												</div>
											</div>
										</div>
                                        
                                        <!-- Section Paramètres -->
                                        <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                                            <div class="profile-setting">
                                                <form action="{{ route('profile.updatee') }}" method="POST">
                                                    @csrf
                                                    <ul class="profile-edit-list row">
                                                        <li class="weight-500 col-md-6">
                                                            <h4 class="text-blue h5 mb-20">Modifier mes infos personnels</h4>
                                                            <div class="form-group">
                                                                <label>Fonction</label>
                                                                <input class="form-control form-control-lg" type="text" name="fonction" value="{{ old('fonction', $user->fonction) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date de naissance</label>
                                                                <input class="form-control form-control-lg date-picker" type="date" name="date_naissance" value="{{ old('date_naissance', $user->date_naissance) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Genre</label>
                                                                <div class="d-flex">
                                                                    <div class="custom-control custom-radio mb-5 mr-20">
                                                                        <input type="radio" id="customRadio4" name="genre" class="custom-control-input" value="male" {{ $user->genre == 'Homme' ? 'checked' : '' }}>
                                                                        <label class="custom-control-label weight-400" for="customRadio4">Homme</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio mb-5">
                                                                        <input type="radio" id="customRadio5" name="genre" class="custom-control-input" value="female" {{ $user->genre == 'Femme' ? 'checked' : '' }}>
                                                                        <label class="custom-control-label weight-400" for="customRadio5">Femme</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                            <label>Ville de résidence :</label>
                                        <select class="custom-select form-control" name="ville">
                                            <option value="Thiés" {{ $user->ville == 'Thiés' ? 'selected' : '' }}>Thiés</option>
                                            <option value="Dakar" {{ $user->ville == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                                            <option value="Tivaouane" {{ $user->ville == 'Tivaouane' ? 'selected' : '' }}>Tivaouane</option>
                                        </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Téléphone</label>
                                                                <input class="form-control form-control-lg" type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Biographie</label>
                                                                <textarea class="form-control" name="biographie">{{ old('biographie', $user->biographie) }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox mb-5">
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck1-1" required>
                                                                    <label class="custom-control-label weight-400" for="customCheck1-1">J'ai bien lu les modifications</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="submit" class="btn btn-success" value="Update Information" style="background-color: #27ae60; color: white;">
                                                            </div>
                                                        </li>

                                                        <!-- Section Modifier mes réseaux sociaux -->
                                                        <li class="weight-500 col-md-6">
                                                            <h4 class="text-blue h5 mb-20">Modifier mes réseaux sociaux</h4>
                                                            <div class="form-group">
                                                                <label>Facebook</label>
                                                                <input class="form-control form-control-lg" type="text" name="facebook" value="{{ old('facebook', $user->facebook) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Twitter</label>
                                                                <input class="form-control form-control-lg" type="text" name="twitter" value="{{ old('twitter', $user->twitter) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>LinkedIn</label>
                                                                <input class="form-control form-control-lg" type="text" name="linkedin" value="{{ old('linkedin', $user->linkedin) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Instagram</label>
                                                                <input class="form-control form-control-lg" type="text" name="instagram" value="{{ old('instagram', $user->instagram) }}">
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="submit" class="btn btn-success" value="Update Social Media" style="background-color: #27ae60; color: white;">
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('src/plugins/cropperjs/dist/cropper.js') }}"></script>
    <script>
		window.addEventListener('DOMContentLoaded', function () {
			var image = document.getElementById('image');
			var cropBoxData;
			var canvasData;
			var cropper;

			$('#modal').on('shown.bs.modal', function () {
				cropper = new Cropper(image, {
					autoCropArea: 0.5,
					dragMode: 'move',
					aspectRatio: 3 / 3,
					restore: false,
					guides: false,
					center: false,
					highlight: false,
					cropBoxMovable: false,
					cropBoxResizable: false,
					toggleDragModeOnDblclick: false,
					ready: function () {
						cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
					}
				});
			}).on('hidden.bs.modal', function () {
				cropBoxData = cropper.getCropBoxData();
				canvasData = cropper.getCanvasData();
				cropper.destroy();
			});
		});
	</script>
    @vite('resources/js/app.js')
@endsection
