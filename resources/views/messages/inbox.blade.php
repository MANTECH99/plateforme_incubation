<!-- inbox.blade.php - Boîte de réception -->
@extends('layouts.app')

@section('title', 'Messagerie - Boîte de réception')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Apps</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Email</a></li>
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
                                    <span class="badge badge-primary badge-sm float-right m-t-5">{{ $unreadCount }}</span>
                                </a>
                                <a href="{{ route('messages.sent') }}" class="list-group-item border-0 p-r-0">
                                    <i class="fa fa-paper-plane font-18 align-middle mr-2"></i> Envoyés
                                </a>
                            </div>
                        </div>
                        <div class="email-right-box">
                            <div class="email-list m-t-15">
                                @if(request()->routeIs('messages.inbox'))
                                    @foreach ($receivedMessages as $message)
                                        <div class="message">
                                            <a href="{{ route('messages.read', $message->id) }}">
                                                <div class="col-mail col-mail-1">
                                                    <div class="email-checkbox">
                                                        <input type="checkbox" id="chk{{ $message->id }}">
                                                        <label class="toggle" for="chk{{ $message->id }}"></label>
                                                    </div>
                                                    <span class="star-toggle ti-star"></span>
                                                </div>
                                                <div class="col-mail col-mail-2">
                                                    <div class="subject">{{ $message->sender->name }}, {{ \Illuminate\Support\Str::limit($message->content, 100) }} <span class="date float-right" style="white-space: nowrap; width: auto; display: inline-block;">{{ $message->created_at->format('d/m/Y H:i') }}</span></div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @elseif(request()->routeIs('messages.sent'))
                                    @foreach ($sentMessages as $message)
                                        <div class="message">
                                            <a href="{{ route('messages.read', $message->id) }}">
                                                <div class="col-mail col-mail-1">
                                                    <div class="email-checkbox">
                                                        <input type="checkbox" id="chk{{ $message->id }}">
                                                        <label class="toggle" for="chk{{ $message->id }}"></label>
                                                    </div>
                                                    <span class="star-toggle ti-star"></span>
                                                </div>
                                                <div class="col-mail col-mail-2">
                                                    <div class="subject">{{ $message->receiver->name }}, {{ \Illuminate\Support\Str::limit($message->content, 100) }} <span class="date float-right" style="white-space: nowrap; width: auto; display: inline-block;">{{ $message->created_at->format('d/m/Y H:i') }}</span></div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        @if ($receivedMessages->currentPage() > 1 || (isset($sentMessages) && $sentMessages->currentPage() > 1))
                                            <a href="{{ request()->routeIs('messages.inbox') ? $receivedMessages->previousPageUrl() : $sentMessages->previousPageUrl() }}" class="btn btn-dark">
                                                <i class="fa fa-angle-left"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-gradient" type="button" disabled><i class="fa fa-angle-left"></i></button>
                                        @endif

                                        @if ($receivedMessages->hasMorePages() || (isset($sentMessages) && $sentMessages->hasMorePages()))
                                            <a href="{{ request()->routeIs('messages.inbox') ? $receivedMessages->nextPageUrl() : $sentMessages->nextPageUrl() }}" class="btn btn-dark">
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-dark" type="button" disabled><i class="fa fa-angle-right"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
