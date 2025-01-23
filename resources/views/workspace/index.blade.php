@extends('layouts.app')

@section('content')
<style>
    .horizontal-sidebar {
    background-color: #27ae60;
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

<div class="main-container" style="width: 100%; margin: 0; padding: 0;">
		<div class="pd-ltr-20">
			<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4">
                    <img src="{{ asset('vendors/images/banner-img.png') }}" alt="">

					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Welcome back <div class="weight-600 font-30 text-blue">{{ auth()->user()->name }} !</div>
						</h4>
						<p class="font-18 max-width-600"> Bienvenue dans votre espace de travail.<br>
                            Ici vous pouvez voir vos séances de mentorats.<br>
                            Consulter  la liste des coachs disponible.<br>
                            et enfin gérer la liste de vos projet. Bon travail !</p>
					</div>
				</div>
                 <!-- ======= Hero Section ======= -->
  <section id="hero">

<div class="container">
  <div class="row">
    <div class="col-lg-6" >
      <h1>Les meilleurs Solutions pour votre projet</h1><br>
      <h2>Faites confiance à notre équipe d'accompagnement</h2>
      <div class="d-flex justify-content-center justify-content-lg-start">
        <a href="{{ route('porteur.projects.index') }}"class="btn-get-started scrollto" style="background-color: #27ae60; color: white;"> Commencons</a>
      </div>
    </div>
    <div class="col-lg-6 order-1 order-lg-2 hero-img" >
      <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="" style="margin-top: -110px;">
      
    </div>
  </div>
</div>

</section><!-- End Hero -->

			</div>

		</div>
        
	</div>

 














	<!-- js -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">

    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

<!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Vendor CSS Files -->


@endsection
