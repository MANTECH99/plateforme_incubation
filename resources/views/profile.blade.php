@extends('layouts.app')

@section('title', 'Profil du Coach')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <!-- Breadcrumb -->
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profil du Coach</a></li>
            </ol>
        </div>
    </div>

    <!-- En-tête -->
    <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profil du Coach</h1>
        </div>

        <!-- Informations du Coach -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color: #27ae60; color: white;">
                        <h6 class="m-0 font-weight-bold">Informations du Coach</h6>
                    </div>
                    <div class="card-body">
                        <h2 class="text-primary">{{ $coach->name }}</h2>
                        <p><strong>Email :</strong> {{ $coach->email }}</p>
                        <p><strong>Biographie :</strong> {{ $coach->bio }}</p>
                        <p><strong>Domaines d'expertise :</strong> {{ $coach->expertise }}</p>
                        <p><strong>Expérience :</strong> {{ $coach->experience }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Message ou Actions -->
        @if(auth()->user()->role->name != 'coach')
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color: #2980b9; color: white;">
                        <h6 class="m-0 font-weight-bold">Envoyer un message à {{ $coach->name }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('messages.send') }}" method="POST">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $coach->id }}">
                            <div class="form-group mb-4">
                                <label for="content" class="form-label">Message :</label>
                                <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color: #8e44ad; color: white;">
                        <h6 class="m-0 font-weight-bold">Actions</h6>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('coach.profile.edit', $coach->id) }}" class="btn btn-success">Éditer mon profil</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
