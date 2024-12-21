<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Carbon\Carbon;

class GoogleMeetService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('google.client_id'));
        $this->client->setClientSecret(config('google.client_secret'));
        $this->client->setRedirectUri(config('google.redirect_uri'));
        $this->client->setScopes(config('google.scopes'));
    }
    public function getClient()
    {
        return $this->client;
    }
    public function authenticate($authCode)
    {
        // Récupérer l'access token et le refresh token
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
        $this->client->setAccessToken($accessToken);

        // Retourner les tokens
        return [
            'access_token' => $accessToken['access_token'],
            'refresh_token' => $accessToken['refresh_token'] ?? null,  // Le refresh token peut être null
        ];
    }



    public function createGoogleMeet($summary, $description, $startDateTime, $endDateTime, $accessToken)
    {
        $this->client->setAccessToken($accessToken); // Assurez-vous que le token est défini
        $service = new Calendar($this->client);
    
        // Formater les dates
        $startDateTime = Carbon::parse($startDateTime)->toRfc3339String();
        $endDateTime = Carbon::parse($endDateTime)->toRfc3339String();
    
        $event = new Calendar\Event([
            'summary' => $summary,
            'description' => $description,
            'start' => ['dateTime' => $startDateTime, 'timeZone' => 'UTC'],
            'end' => ['dateTime' => $endDateTime, 'timeZone' => 'UTC'],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => uniqid(),
                ],
            ],
        ]);
    
        try {
            $createdEvent = $service->events->insert('primary', $event, ['conferenceDataVersion' => 1]);
            return $createdEvent->getHangoutLink();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
