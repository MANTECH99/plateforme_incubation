@extends('layouts.app')

@section('title', 'Lire un Message')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- Container Fluid -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="email-left-box">
                            <a href="{{ route('messages.compose') }}" class="btn btn-primary btn-block">Compose</a>
                            <div class="mail-list mt-4">
                                <a href="{{ route('messages.inbox') }}" class="list-group-item border-0 text-primary p-r-0">
                                    <i class="fa fa-inbox font-18 align-middle mr-2"></i> <b>Boîte de réception</b>
                                    <span class="badge badge-primary badge-sm float-right m-t-5">{{ $unreadCount ?? 0 }}</span>
                                </a>
                                <a href="{{ route('messages.sent') }}" class="list-group-item border-0 p-r-0">
                                    <i class="fa fa-paper-plane font-18 align-middle mr-2"></i> Envoyés
                                </a>
                            </div>
                        </div>
                        <div class="email-right-box">
                            <div class="read-content">
                                <div class="media pt-5">
                                    <div class="media-body">
                                        <h5 class="m-b-3">{{ $message->sender->name }}</h5>
                                        <p class="m-b-2">{{ $message->created_at->format('d/m/Y') }}</p><br>
                                    </div>
                                </div>
                                <hr>
                                <div class="media mb-4 mt-1">
                                    <div class="media-body"><span class="float-right">{{ $message->created_at->format('H:i') }}</span>
                                        <h4 class="m-0 text-primary">Contenu du message : <br><br> {{ \Illuminate\Support\Str::limit($message->content, 50) }}</h4>
                                    </div>
                                </div>
                                <hr>
                                
                                <!-- Afficher la réponse uniquement si l'utilisateur est le destinataire -->
                                @if (auth()->id() == $message->receiver_id)
                                    <div class="form-group p-t-15">
                                        <form action="{{ route('messages.send') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="receiver_id" value="{{ $message->sender->id }}">
                                            <input type="hidden" name="subject" value="Re: {{ $message->subject }}">
                                            <textarea class="w-100 p-20 l-border-1" name="content" id="content" cols="30" rows="5" placeholder="Répondre..."></textarea>
                                            <div class="text-right mt-3">
                                                <button class="btn btn-primary w-md m-b-30" type="submit">Envoyer</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
@endsection
