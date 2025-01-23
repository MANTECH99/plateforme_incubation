@extends('layouts.app')

@section('title', 'Profil du Coach')

@section('content')


    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">

    <style>
    .horizontal-sidebar {
    background-color: rgba(30, 125, 50, 0.1); 
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.horizontal-sidebar .nav-tabs {
    border-bottom: none;
    justify-content: center;
}

.horizontal-sidebar .nav-tabs .nav-link {
    color: #333;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 0;
    transition: all 0.3s ease;
}

.horizontal-sidebar .nav-tabs .nav-link.active {
    background-color: #27ae60;
    color: #fff;
    font-weight: bold;
}

</style>
<div class="container">
    <div class="horizontal-sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('porteur.projects.index') ? 'active' : '' }}" href="{{ route('porteur.projects.index') }}">
                    Mes projets
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('mentorship_sessions.index') ? 'active' : '' }}" href="{{ route('mentorship_sessions.index') }}">
                    Séances de mentorat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('porteur.coaches') ? 'active' : '' }}" href="{{ route('porteur.coaches') }}">
                    Liste des coachs
                </a>
            </li>
        </ul>
    </div>
    <div class="workspace-content mt-4">
        @yield('workspace-content')
    </div>
</div>

    

<div class="content-body" style="width: 100%; margin: 0; padding: 0;">


   <!-- Informations du Coach et Envoyer un message côte à côte -->
<div class="row">
    <!-- Informations du Coach -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #27ae60; color: white;">
                <h6 class="m-0 font-weight-bold" style="text-align: center; color: white;">Informations du Coach</h6>
            </div>




            <div class="pd-20">
												<div class="profile-timeline">
                                                <div class="timeline-month">
														<h5 class="mb-20 h5 text-blue">{{ $coach->name }}</h5>
													</div>
													<div class="profile-timeline-list">
														<ul>
															<li>
                                                            <div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>

																<div class="task-name"> Biographie</div>
																<p>{{ $coach->biographie }}</p>
																
															</li>
															<li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name"> Adresse Email</div>
																<p>{{ $coach->email }}</p>
															</li>
                                                            <li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name">Numéro téléphone</div>
																<p>{{ $coach->telephone }}</p>
															</li>
															<li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name">Domaine d'expertise</div>
																<p>{{ $coach->expertise }}</p>
																
															</li>
															<li>
																<div class="date">{{ $user->updated_at->format('d-m-Y') }}</div>
																<div class="task-name">Expérience</div>
																<p>{{ $coach->experience }}</p>
																
															</li>
														</ul>
													</div>
                                                    <div class="card-body text-center">
                <form action="{{ route('requests.relation') }}" method="POST">
                    @csrf
                    <input type="hidden" name="coach_id" value="{{ $coach->id }}">
                    <button type="submit" class="btn btn-success" style="background-color: #27ae60; color: white;">Demander une mise en relation</button>
                </form>
            </div>

												</div>
											</div>
										








        </div>
    </div>

    
    <!-- Envoyer un message au Coach -->
    @if(auth()->user()->role->name != 'coach')
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #27ae60; color: white;">
                <h6 class="m-0 font-weight-bold" style="text-align: center; color: white;">Envoyer un message à {{ $coach->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('messages.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $coach->id }}">
                    <div class="form-group mb-4">
                        <label for="content" class="form-label">Message :</label>
                        <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="profile-social">
								<h5 class="mb-20 h5 text-blue">Réseaux Sociaux</h5>
								<ul class="clearfix">
									<li><a href="{{ $user->facebook }}" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"><i class="fa fa-facebook"></i></a></li>
									<li><a href="{{ $user->twitter }}" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"><i class="fa fa-twitter"></i></a></li>
									<li><a href="{{ $user->linkedin }}" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="{{ $user->instagram }}" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div><br>
                    <button type="submit" class="btn btn-success" style="background-color: #27ae60; color: white;">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>


    </div>
</div>
    <!-- js -->

@endsection
