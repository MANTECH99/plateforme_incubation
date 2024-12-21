<!-- partials/sidebar.blade.php -->
<style>
    .nk-sidebar a {
    text-decoration: none !important; /* Supprime le soulignement */
    color: inherit; /* Conserve la couleur du texte définie dans le design */
}

.nk-sidebar a:hover {
    text-decoration: none; /* Aucun soulignement au survol */
    color: #007bff; /* Couleur au survol (ajustez selon votre design) */
}

</style>
<div class="nk-sidebar">           
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
        <li>
    <a href="{{ route(auth()->user()->role->name . '.dashboard') }}" aria-expanded="false">
        <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
    </a>
</li>


            @if(auth()->user()->role->name == 'porteur de projet')
                <li class="mega-menu mega-menu-sm">
                    <a href="{{ route('porteur.projects.index') }}" aria-expanded="false">
                        <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Mes projets</span>
                    </a>    
                </li>
                <li>
                    <a href="{{ route('porteur.resources.index') }}">
                        <i class="icon-notebook menu-icon"></i>Centre de ressources
                    </a>
                </li>
                <li>
                    <a href="{{ route('mentorship_sessions.index') }}" aria-expanded="false">
                        <i class="icon-grid menu-icon"></i><span class="nav-text">Séances de mentorat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('porteur.coaches') }}" aria-expanded="false">
                        <i class="icon-badge menu-icon"></i><span class="nav-text">Liste des coachs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('documents.index') }}">
                        <i class="icon-docs menu-icon"></i>Documents partagés
                    </a>
                </li>
            @endif

            @if(auth()->user()->role->name == 'coach')
                <li>
                    <a href="{{ route('coach.projects.index') }}" aria-expanded="false">
                        <i class="icon-list menu-icon"></i><span class="nav-text">Projets à coacher</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mentorship_sessions.index') }}" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i><span class="nav-text">Mes séances de mentorat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('coach.profile', auth()->id()) }}" aria-expanded="false">
                        <i class="icon-user menu-icon"></i><span class="nav-text">Mon Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('resources.index') }}" aria-expanded="false">
                        <i class="icon-notebook menu-icon"></i>Centre de ressources
                    </a>
                </li>
                <li>
                    <a href="{{ route('documents.index') }}">
                        <i class="icon-docs menu-icon"></i>Documents partagés
                    </a>
                </li>
            @endif

            @if(auth()->user()->role->name == 'admin')
                <li>
                    <a href="{{ route('admin.users.index') }}" aria-expanded="false">
                        <i class="icon-people menu-icon"></i><span class="nav-text">Gérer les utilisateurs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.projects.index') }}" aria-expanded="false">
                        <i class="icon-briefcase menu-icon"></i><span class="nav-text">Tous les projets</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.assign-coach-form') }}" aria-expanded="false">
                        <i class="icon-user-follow menu-icon"></i><span class="nav-text">Assigner un Coach</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('resources.index') }}" aria-expanded="false">
                        <i class="icon-notebook menu-icon"></i>Centre de ressources
                    </a>
                </li>
                <li>
                    <a href="{{ route('documents.index') }}">
                        <i class="icon-docs menu-icon"></i>Documents partagés
                    </a>
                </li>
            @endif

            <!-- Messagerie est accessible à tous les rôles -->
            <li>
                <a href="{{ route('messages.inbox') }}" aria-expanded="false">
                    <i class="icon-envelope menu-icon"></i> <span class="nav-text">Messagerie</span>
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i></i> <span class="nav-text">Notifications et Suivis</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}" aria-expanded="false">
                <i class="icon-notebook menu-icon"></i></i> <span class="nav-text">Cours en ligne</span>
                </a>
            </li>

        </ul>
    </div>
</div>
