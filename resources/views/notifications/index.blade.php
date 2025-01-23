@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
<div class="container mt-4" style="width: 100%; margin: 0; padding: 0;">
    <h1 class="mb-3">Mes Notifications</h1>

    @if($notifications->isEmpty())
        <div class="alert alert-info text-center">Aucune notification disponible pour le moment.</div>
    @else
        @php
            // Regrouper les notifications par type
            $grouped = $notifications->groupBy(fn($n) => $n->data['type'] ?? 'autre');
        @endphp

        <!-- Onglets -->
        <ul class="nav nav-tabs mb-3" id="notificationTabs" role="tablist">
            @foreach($grouped as $type => $group)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $type }}-tab" data-toggle="tab" href="#{{ $type }}" role="tab" aria-controls="{{ $type }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ ucfirst($type) }} <span class="badge bg-success">{{ $group->count() }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Contenu des onglets -->
        <div class="tab-content" id="notificationTabsContent">
            @foreach($grouped as $type => $group)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $type }}" role="tabpanel" aria-labelledby="{{ $type }}-tab">
                    <div class="card shadow-sm">
                        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #27ae60 ; color: white;">
                            <span>{{ ucfirst($type) }}</span>
                            <span class="badge bg-light text-dark">{{ $group->count() }} notifications</span>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($group as $notification)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column">
        <div class="d-flex align-items-center">
            <strong>{{ $notification->data['title'] }}</strong>&nbsp;:&nbsp;
            <span>{{ $notification->data['message'] }}</span>
            <small class="text-muted mx-2">{{ $notification->created_at->diffForHumans() }}</small>
            @if(isset($notification->data['url']))
                <a href="{{ $notification->data['url'] }}" class="btn btn-link p-0">Voir</a>
            @endif
        </div>
    </div>
                                    <div>
                                        @if(is_null($notification->read_at))
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm" style="background-color: #27ae60     ; color: white;">Marquer comme lue</button>
                                            </form>
                                        @else
                                        <span class="badge bg-light text-dark border">Déjà lue</span>

                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    document.querySelectorAll('.mark-as-read').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const notificationId = this.getAttribute('data-id');

            fetch(`/notifications/${notificationId}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprime la notification de la liste
                    const notificationElement = this.closest('li');
                    notificationElement.remove();

                    // Met à jour le compteur
                    const countElement = document.getElementById('notification-count');
                    countElement.textContent = data.unreadCount;

                    // Si toutes les notifications ont été supprimées
                    if (data.unreadCount === 0) {
                        const notificationList = document.querySelector('.dropdown-content-body ul');
                        notificationList.innerHTML = '<li class="text-center">Aucune notification non lue</li>';
                    }
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
</script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS (besoin de Popper.js inclus automatiquement avec Bootstrap 5) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
