<!-- inbox.blade.php - Boîte de réception -->
@extends('layouts.app')

@section('title', 'Composer un Message')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <!-- Container Fluid -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="email-left-box">
                            <a href="{{ route('messages.compose') }}" class="btn btn-success btn-block" style="background-color: #27ae60     ; color: white;">Compose</a>
                            <div class="mail-list mt-4">
                                <a href="{{ route('messages.inbox') }}" class="list-group-item border-0 text-success p-r-0">
                                    <i class="fa fa-inbox font-18 align-middle mr-2"></i> <b>Boîte de réception</b>
                                    <span class="badge badge-success badge-sm float-right m-t-5">{{ $unreadCount ?? 0 }}</span>
                                </a>
                                <a href="{{ route('messages.sent') }}" class="list-group-item border-0 p-r-0">
                                    <i class="fa fa-paper-plane font-18 align-middle mr-2"></i> Envoyés
                                </a>
                            </div>
                        </div>
                        <div class="email-right-box">
                            <div class="compose-content mt-5">
                                <form method="POST" action="{{ route('messages.send') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="receiver_id">Destinataire :</label>
                                        <select name="receiver_id" id="receiver_id" class="form-control bg-transparent" required>
                                            <option value="">Sélectionnez un destinataire</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="subject" class="form-control bg-transparent" placeholder="Subject">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="content" class="textarea_editor form-control bg-light" rows="15" placeholder="Enter text ..." required></textarea>
                                    </div>
                                    <h5 class="m-b-20"><i class="fa fa-paperclip m-r-5 f-s-18"></i> Attachment</h5>
                                    <div class="form-group">
                                        <input class="l-border-1" name="attachments[]" type="file" multiple="multiple">
                                    </div>
                                    <div class="text-left m-t-15">
                                        <button type="submit" class="btn btn-success m-b-30 m-t-15 f-s-14 p-l-20 p-r-20 m-r-10"><i class="fa fa-paper-plane m-r-5"></i> Send</button>
                                        <a href="{{ route('messages.inbox') }}" class="btn btn-dark m-b-30 m-t-15 f-s-14 p-l-20 p-r-20"><i class="ti-close m-r-5 f-s-12"></i> Annuler</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
