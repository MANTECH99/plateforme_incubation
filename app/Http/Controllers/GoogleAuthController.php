<?php

namespace App\Http\Controllers;

use App\Services\GoogleMeetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }
    public function redirect()
    {
        // Générez l'URL de redirection Google OAuth
        $client = $this->googleMeetService->getClient();
        $authUrl = $client->createAuthUrl();

        // Redirigez l'utilisateur vers l'URL d'authentification Google
        return redirect($authUrl);
    }
    public function handleCallback(Request $request)
    {
        logger('Début du callback Google.');
        
        // Avant l'authentification
        logger('Session avant l\'authentification Google : ' . session()->getId());
    
        $authCode = $request->input('code');
        $accessToken = $this->googleMeetService->authenticate($authCode);
    
        // Vérifiez si l'utilisateur est authentifié
        if (!Auth::check()) {
            // Après avoir vérifié l'utilisateur
            logger('Utilisateur non authentifié pendant le callback. Session ID : ' . session()->getId());
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour lier votre compte Google.');
        }
    
        logger('Utilisateur authentifié : ' . Auth::id());
        $user = Auth::user();
    
        if (!$user) {
            logger('Erreur : utilisateur non récupéré même après Auth::check().');
            return redirect()->route('login')->with('error', 'Impossible de trouver l\'utilisateur connecté.');
        }
    
        // Enregistrer les tokens OAuth dans la base de données
        $user->google_oauth_token = $accessToken['access_token'];
        $user->google_refresh_token = $accessToken['refresh_token'] ?? null;
        $user->save();
    
        // Après l'authentification et la sauvegarde
        logger('Session après l\'authentification Google : ' . session()->getId());
        logger('Compte Google connecté avec succès pour l\'utilisateur : ' . $user->id);
    
        return redirect('/mentorship_sessions/create')->with('success', 'Compte Google connecté avec succès!');
    }
    
    
}
