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
                <a class="nav-link {{ Request::routeIs('coach.projects.index') ? 'active' : '' }}" href="{{ route('coach.projects.index') }}">
                    Projets à coacher
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('mentorship_sessions.index') ? 'active' : '' }}" href="{{ route('mentorship_sessions.index') }}">
                    Séances de mentorat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('profile.view') ? 'active' : '' }}" href="{{ route('profile.view') }}">
                    Mon Profil
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
                            Ici vous pouvez gérer vos séances de mentorats.<br>
                            Voir votre profil et apporter des mises à jour.<br>
                            Et enfin gérer la liste des projets que vous accompagnez. Bon travail !</p>
					</div>
				</div>
        <!-- Hero Section -->
<section id="hero" class="hero section">

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="row align-items-center" style="margin-top: -115px;">
    <div class="col-lg-6">
      <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
      <div class="company-badge mb-4" style="background-color: rgba(39, 174, 96, 0.1); color: #27ae60; border: 1px solid #27ae60; padding: 10px 15px; border-radius: 5px; display: inline-block;">
  <i class="bi bi-gear-fill me-2"></i>
  Travaillez pour votre Succès
</div>


        <h1 class="mb-4" >
          Votre Vision <br>
          Notre Mission <br>
          <span class="accent-text" style="color: #27ae60;">InnovZig SN</span>
        </h1><br>


        <div class="hero-buttons">
          <a href="{{ route('coach.projects.index') }}" class="btn btn-primary me-0 me-sm-2 mx-1" style="background-color: #27ae60; color: white;">Commencons</a>
          </a>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
      <img src="{{ asset('assets/img/illustration-1.webp') }}" alt="Hero Image" class="img-fluid" style="margin-top: -30px;">


        <div class="customers-badge">
          <div class="customer-avatars">
          <img src="{{ asset('assets/img/avatar-1.webp') }}" alt="Customer 1" class="avatar">
<img src="{{ asset('assets/img/avatar-2.webp') }}" alt="Customer 2" class="avatar">
<img src="{{ asset('assets/img/avatar-3.webp') }}" alt="Customer 3" class="avatar">
<img src="{{ asset('assets/img/avatar-4.webp') }}" alt="Customer 4" class="avatar">
<img src="{{ asset('assets/img/avatar-5.webp') }}" alt="Customer 5" class="avatar">

            <span class="avatar more">12+</span>
          </div>
          <p class="mb-0 mt-2">12,000+ transformer vos idées en succès</p>
        </div>
      </div>
    </div>
  </div>



</div>

</section><!-- /Hero Section -->

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>                                   
			</div>

		</div>
	</div>

















	<!-- js -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

<!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection
