<style>
/* Supprime le soulignement des liens dans le header */
.header a {
    text-decoration: none !important; /* Supprime le soulignement */
    color: inherit; /* Conserve la couleur actuelle des liens */
}

.header a:hover {
    text-decoration: none; /* Aucun soulignement au survol */
    color: #007bff; /* Couleur personnalisée au survol */
}

/* Si vous voulez une couleur spécifique pour les liens actifs */
.header a:active {
    color: #0056b3; /* Ajustez selon votre design */
}
</style>

<div class="nav-header" style="display: flex; justify-content: center; align-items: center; height: 100px; background-color: white;">
    <div class="brand-logo" style="display: flex; flex-direction: column; align-items: center;">
        <b class="logo-abbr"><img src="{{ asset('images/logo.png') }}" alt="Logo abrégé" style="max-height: 50px; margin-bottom: 10px;"> </b>
        <span class="logo-compact"><img src="{{ asset('images/logo-compact.png') }}" alt="Logo compact" style="max-height: 30px; margin-bottom: 5px;"></span>
        <span class="brand-title">
            <img src="{{ asset('images/logo-text.png') }}" alt="Logo texte" style="max-height: 40px;">
        </span>
    </div>
</div>



<div class="header">    
    <div class="header-content clearfix">
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>
        <div class="header-left">
            <div class="input-group icons">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                </div>
                <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
            </div>
        </div>
        <div class="header-right">
            <ul class="clearfix">
                <!-- Messages Dropdown -->
                <li class="icons dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown">
                        <i class="mdi mdi-email-outline"></i>
                        <span class="badge badge-pill gradient-1">{{ $unreadMessagesCount }}</span>
                    </a>
                    <div class="drop-down animated fadeIn dropdown-menu">
                        <div class="dropdown-content-heading d-flex justify-content-between">
                            <span class="">{{ $unreadMessagesCount }} New Messages</span>  
                            <a href="{{ route('messages.inbox') }}" class="d-inline-block">
                                <span class="badge badge-pill gradient-1">{{ $unreadMessagesCount }}</span>
                            </a>
                        </div>
                        <div class="dropdown-content-body">
                            <ul>
                                @foreach($recentMessages as $message)
                                    <li class="notification-unread">
                                        <a href="{{ route('messages.read', $message->id) }}">
                                            <img class="float-left mr-3 avatar-img" src="{{ asset('images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content">
                                                <div class="notification-heading">{{ $message->sender->name }}</div>
                                                <div class="notification-timestamp">{{ $message->created_at->diffForHumans() }}</div>
                                                <div class="notification-text">{{ \Illuminate\Support\Str::limit($message->content, 50) }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>
<!-- Notifications Dropdown -->
<li class="icons dropdown">
    <a href="javascript:void(0)" data-toggle="dropdown">
        <i class="mdi mdi-bell-outline"></i>
        <span id="notification-count" class="badge badge-pill gradient-2">{{ $unreadNotificationsCount }}</span>
    </a>
    <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
    <div class="dropdown-content-heading d-flex justify-content-between align-items-center">
    <span class="font-weight-bold">Nouvelles Notifications</span>
    <a href="{{ route('notifications.index') }}" class="badge badge-pill gradient-2 d-inline-block text-white text-center" style="text-decoration: none; width: 80px;">
        <span">Voir tout</span>
    </a>
    <span class="badge badge-pill gradient-2">{{ $unreadNotificationsCount }}</span>
</div>

        <div class="dropdown-content-body">
    <ul>
        @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
            <li>
                <a href="{{ $notification->data['url'] ?? '#' }}" class="mark-as-read" data-id="{{ $notification->id }}">
                    <strong>{{ $notification->data['title'] }}</strong>
                    <span>{{ $notification->data['message'] }}</span>
                </a>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </li>
        @endforeach
        @if(auth()->user()->unreadNotifications->isEmpty())
            <li class="text-center">Aucune notification non lue</li>
        @endif
                <!-- Afficher un lien pour voir toutes les notifications -->
                <li class="text-center mt-2">
            <a href="{{ route('notifications.index') }}"  class="badge badge-pill gradient-2 d-inline-block text-white text-center" style="text-decoration: none; width: 280px; height: 25px;">
                Voir toutes les notifications
            </a>
        </li>
    </ul>
</div>

    </div>
</li>


                <!-- User Profile Dropdown -->
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('images/user/1.png') }}" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="{{ url('/profile') }}"><i class="icon-user"></i> <span>Mon profil</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('messages.inbox') }}">
                                        <i class="icon-envelope-open"></i> <span>Messagerie</span> <div class="badge gradient-3 badge-pill gradient-1">{{ $unreadMessagesCount }}</div>
                                    </a>
                                </li>
                                <hr class="my-2">
                                <li>
                                    <!-- Formulaire de déconnexion -->
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-danger" style="padding: 0; text-decoration: none;">
                                            <i class="icon-key"></i> <span>Se déconnecter</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
