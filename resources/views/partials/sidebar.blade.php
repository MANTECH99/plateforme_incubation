<style>
    .sidebar .nav-link {
  color: #333; /* Couleur par défaut du texte */
  background-color: transparent; /* Pas de fond par défaut */
  transition: all 0.3s ease; /* Transition douce */
}

.sidebar .nav-link:hover {
  color: #fff; /* Texte blanc au survol */
  background-color: #27ae60  !important; /* Bleu clair au survol */
}

.sidebar .nav-link.active {
  color: #fff; /* Texte blanc */
  background-color: #27ae60  !important; /* Bleu plus foncé pour actif */
  font-weight: bold; /* Texte en gras pour actif */
}

.sidebar .nav-link:focus {
  outline: none; /* Supprimer le contour par défaut au focus */
  background-color: #27ae60 !important; /* Bleu encore plus foncé pour le focus */
}

</style>
<!-- partials/sidebar.blade.php -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
                <a class="nav-link {{ Request::routeIs(auth()->user()->role->name . '.dashboard') ? 'active' : '' }}" href="{{ route(auth()->user()->role->name . '.dashboard') }}" >
                <i class="mdi mdi-border-all mdi-18px"></i>&nbsp;&nbsp;
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

            @if(auth()->user()->role->name == 'porteur de projet')
            <li class="nav-item">
    <a class="nav-link {{ Request::routeIs('porteur.workspace') ? 'active' : '' }}" href="{{ route('porteur.workspace') }}">
        <i class="mdi mdi-briefcase mdi-18px"></i>&nbsp;&nbsp;
        <span class="menu-title">Espace de travail</span>
    </a>
</li>

            @endif

            @if(auth()->user()->role->name == 'coach')
<li class="nav-item">
    <a class="nav-link {{ Request::routeIs('coach.workspace') ? 'active' : '' }}" href="{{ route('coach.workspace') }}">
        <i class="mdi mdi-briefcase mdi-18px"></i>&nbsp;&nbsp;
        <span class="menu-title">Espace de travail</span>
    </a>
</li>
@endif


            @if(auth()->user()->role->name == 'admin')
            <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}" >
                    <i class="mdi mdi-account-multiple mdi-18px"></i>&nbsp;&nbsp;<span class="menu-title">Gérer les utilisateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.projects.index') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}" >
                    <i class="mdi mdi-server mdi-18px"></i>&nbsp;&nbsp;<span class="menu-title">Tous les projets</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.assign-coach-form') ? 'active' : '' }}" href="{{ route('admin.assign-coach-form') }}" >
                    <i class="mdi mdi-account-plus mdi-18px"></i>&nbsp;&nbsp;<span class="menu-title">Assigner un Coach</span>
                    </a>
                </li>
            @endif

            <!-- Messagerie est accessible à tous les rôles -->
            <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('resources.index') ? 'active' : '' }}" href="{{ route('resources.index') }}" >
                    <i class="mdi mdi-file-document mdi-18px"></i>&nbsp;&nbsp;Centre de ressources
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('documents.index') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                    <i class="mdi mdi-folder-outline mdi-18px"></i>&nbsp;&nbsp;Documents partagés
                    </a>
                </li>
                <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('messages.inbox') ? 'active' : '' }}" href="{{ route('messages.inbox') }}" >
                <i class="mdi mdi-comment-processing-outline mdi-18px"></i>&nbsp;&nbsp;<span class="menu-title">Messagerie</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('notifications.index') ? 'active' : '' }}" href="{{ route('notifications.index') }}" >
                <i class="mdi mdi-bell-ring mdi-18px"></i>&nbsp;&nbsp;<span class="menu-title">Notifications et Suivis</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}" >
                <i class="mdi mdi-laptop-mac mdi-18px"></i>&nbsp;&nbsp; <span class="menu-title">Cours en ligne</span>
                </a>
            </li>
        </ul>
        </nav>
