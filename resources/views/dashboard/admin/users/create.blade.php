<!-- resources/views/dashboard/admin/users/create.blade.php -->
@extends('layouts.app')

@section('title', 'Créer un Nouvel Utilisateur')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Créer un Utilisateur</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer un Nouvel Utilisateur</h1>
    </div>
    <div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white py-3">
                <h6 class="m-0 font-weight-bold">Formulaire de Création d'Utilisateur</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Entrez le nom" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'email" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Mot de Passe</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Entrez un mot de passe" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmez le mot de passe" required>
                    </div>

                    <div class="form-group mb-4">
                        <label for="role_id" class="form-label">Rôle</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="" disabled selected>Sélectionnez un rôle</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Créer l'Utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
@endsection

