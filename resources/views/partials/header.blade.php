<style>
/* Styles personnalisés pour le header */
.navbar-brand img {
    max-height: 50px;
}

.nav-item .count {
    background-color: #f44336;
    border-radius: 50%;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    position: absolute;
    top: 10px;
    right: 5px;
}

.navbar-menu-wrapper .input-group .form-control {
    border: 2px solid #4CAF50; /* Bordure verte */
    border-radius: 20px;
    padding: 5px 10px;
}

.navbar-menu-wrapper .input-group .form-control:focus {
    outline: none;
    box-shadow: 0 0 5px #4CAF50; /* Effet de surbrillance vert */
}

.navbar .dropdown-menu {
    min-width: 250px;
}

.dropdown-header {
    font-weight: bold;
    text-transform: uppercase;
}

.notification-unread {
    font-weight: bold;
}


/* Animation pour le texte défilant */
.marquee-container {
    overflow: hidden;
    white-space: nowrap;
    width: 100%; /* Ajuster la largeur selon vos besoins */
    display: inline-block;
    position: relative;
    margin-left: 20px;
}

.marquee {
    display: inline-block;
    animation: marquee 20s linear infinite; /* Ajuster la durée de l'animation */
    font-weight: bold; /* Texte en gras */
    color: #27ae60;
    font-size: 20px; /* Taille du texte */
    transform: translateX(50%); /* Commence au milieu */
    animation-delay: 0s; /* Pas de délai avant le démarrage */
}

@keyframes marquee {
    0% {
        transform: translateX(70%); /* Position initiale : au milieu */
    }
    100% {
        transform: translateX(-100%); /* Texte défile vers la gauche */
    }
}   

/* Logo container */
.logoss {
    text-align: center;
}

.logoss img {
    width: 100px; /* Ajuste la taille du logo */
    height: auto;
    margin-right: 0px;
}

.dropdown-menu a {
    text-decoration: none !important; /* Supprime le soulignement */
    color: inherit; /* Garde la couleur par défaut */
}

.dropdown-menu a:hover {
    color: #27ae60; /* Couleur verte au survol */
}

.dropdown-menu .mark-as-read {
    font-weight: normal; /* Texte normal */
}

</style>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-text.png') }}" class="mr-2" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-text.png') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <!-- Logo à la place du champ de recherche -->
        <div class="logoss">
        <img src="{{ asset('images/uasz.png') }}" alt="Logo">
        </div>
        <div class="marquee-container">
            <span class="marquee">Bienvenue sur notre plateforme d'incubation. L’Université Assane Seck de Ziguinchor (UASZ) s’est dotée d’un incubateur pour soutenir les projets innovants des étudiants et des entrepreneurs locaux.</span>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    <span id="notification-count" class="badge badge-pill badge-success">{{ $unreadNotificationsCount }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <span class="font-weight-bold">Nouvelles Notifications</span> <span class="badge badge-pill badge-success">{{ $unreadNotificationsCount }}</span>
                    <div class="dropdown-content-body">
                        <ul>
                            @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                                <li>
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="mark-as-read" data-id="{{ $notification->id }}">
                                        <strong>{{ $notification->data['title'] }}</strong>
                                        <span>{{ $notification->data['message'] }}</span>
                                    </a><br>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                            @if(auth()->user()->unreadNotifications->isEmpty())
                                <li class="text-center">Aucune notification non lue</li>
                            @endif
                            <li class="text-center mt-2">
                            <a href="{{ route('notifications.index') }}" class="badge badge-pill badge-success d-inline-block text-black text-center" style="text-decoration: none; width: 300px; height: 25px; font-weight: bold; display: flex; align-items: center; justify-content: center;">
    Voir toutes les notifications
</a>

                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- User Profile Dropdown -->
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <img id="image" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Picture">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{ route('profile.editt') }}">
                    <i class="icon-user"></i>Remplir mon profil
                    </a>
                    <a class="dropdown-item" href="{{ url('/profile') }}">
                    <i class="ti-settings text-primary"></i>Paramétres
                    </a>
                    <a class="dropdown-item" href="{{ route('messages.inbox') }}">
                        <i class="icon-envelope-open"></i> Messagerie
                        <span class="badge badge-pill gradient-1">{{ $unreadMessagesCount }}</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger p-0" style="text-decoration: none;">
                                <i class="ti-power-off text-primary"></i> Se déconnecter
                            </button>
                        </form>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
