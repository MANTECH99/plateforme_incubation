<?php

namespace App\Http\Controllers;

use App\Services\GoogleMeetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MentorshipSession;

class MeetingController extends Controller
{
    protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }

    public function createMeeting(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id', // Validation pour s'assurer que le projet existe
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    
        try {
            $user = Auth::user(); // Récupérer l'utilisateur authentifié
    
            if (!$user || !$user->google_oauth_token) {
                // Si l'utilisateur n'est pas authentifié ou s'il n'a pas de token d'accès
                return response()->json(['error' => 'User not authenticated or missing Google OAuth token'], 401);
            }
    
            $accessToken = $user->google_oauth_token; // Utiliser le token d'accès stocké dans la base de données
    
            // Passer le token à la méthode pour créer la réunion
            $meetingLink = $this->googleMeetService->createGoogleMeet(
                $validated['summary'],
                $validated['description'] ?? '',
                $validated['start_time'],
                $validated['end_time'],
                $accessToken // Passer le token ici
            );

                    // Enregistrer la réunion dans la base de données
        $mentorshipSession = new MentorshipSession();
        $mentorshipSession->project_id = $validated['project_id']; // Utiliser le project_id validé
        $mentorshipSession->coach_id = $user->id;
        $mentorshipSession->start_time = $validated['start_time'];
        $mentorshipSession->end_time = $validated['end_time'];
        $mentorshipSession->notes = $validated['description'] ?? '';
        $mentorshipSession->meeting_link = $meetingLink;
        $mentorshipSession->save();
    
            return response()->json(['link' => $meetingLink], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
