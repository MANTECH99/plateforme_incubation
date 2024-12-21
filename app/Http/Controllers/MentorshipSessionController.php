<?php

namespace App\Http\Controllers;

use App\Models\MentorshipSession;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\GoogleMeetService;
use Illuminate\Support\Facades\Auth;

class MentorshipSessionController extends Controller
{
    protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }

    public function index()
    {
        $user = auth()->user();
    
        if ($user->role->name === 'porteur de projet') {
            // Récupère les projets du porteur et les séances associées
            $projects = $user->projects()->pluck('id');
            $sessions = MentorshipSession::with('project', 'coach')
                ->whereIn('project_id', $projects)
                ->get();
        } elseif ($user->role->name === 'coach') {
            // Récupère les séances créées par le coach
            $sessions = MentorshipSession::with('project', 'coach')
                ->where('coach_id', $user->id)
                ->get();
        } else {
            $sessions = collect();
        }
    
        return view('mentorship_sessions.index', compact('sessions'));
    }

    public function create()
    {
        $coach = auth()->user();

        if ($coach->role->name === 'coach') {
            // Récupère les projets accompagnés par le coach
            $projects = $coach->projectsCoached;
        } else {
            $projects = collect();
        }

        return view('mentorship_sessions.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string',
            'meeting_link' => 'nullable|url',
        ]);

        // Si un lien de réunion est fourni, on le garde, sinon on crée un lien via Google Meet
        $meetingLink = $validated['meeting_link'] ?? null;

        if (!$meetingLink) {
            try {
                $user = Auth::user();
                if (!$user || !$user->google_oauth_token) {
                    return response()->json(['error' => 'User not authenticated or missing Google OAuth token'], 401);
                }

                $accessToken = $user->google_oauth_token;
                $meetingLink = $this->googleMeetService->createGoogleMeet(
                    "Séance de Mentorat",
                    $validated['notes'] ?? '',
                    $validated['start_time'],
                    $validated['end_time'],
                    $accessToken
                );
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        MentorshipSession::create([
            'project_id' => $validated['project_id'],
            'coach_id' => auth()->id(),
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'notes' => $validated['notes'],
            'meeting_link' => $meetingLink,
        ]);

        return redirect()->route('mentorship_sessions.index')->with('success', 'Session créée avec succès.');
    }

    public function destroy(MentorshipSession $mentorshipSession)
    {
        $mentorshipSession->delete();
        return redirect()->route('mentorship_sessions.index')->with('success', 'Session supprimée.');
    }

    public function apiIndex()
    {
        $user = auth()->user();
    
        // Vérification du rôle
        if ($user->role->name === 'coach') {
            // Si l'utilisateur est un coach, afficher les séances qu'il a créées
            $sessions = MentorshipSession::with('project', 'coach')
                ->where('coach_id', $user->id)
                ->get();
        } elseif ($user->role->name === 'porteur de projet') {
            // Si l'utilisateur est un porteur de projet, afficher les séances liées à ses projets
            $projectIds = $user->projects()->pluck('id');
            $sessions = MentorshipSession::with('project', 'coach')
                ->whereIn('project_id', $projectIds)
                ->get();
        } else {
            // Si le rôle est inconnu, aucune session n'est affichée
            $sessions = collect();
        }
    
        // Formater les séances pour le calendrier
        $formattedSessions = $sessions->map(function ($session) {
            return [
                'id' => $session->id,
                'title' => $session->project->title . ' - Coach : ' . $session->coach->name,
                'start' => $session->start_time,
                'end' => $session->end_time,
                'url' => $session->meeting_link, // Ajout du lien de la réunion
            ];
        });
    
        return response()->json($formattedSessions);
    }
    

    
    

}