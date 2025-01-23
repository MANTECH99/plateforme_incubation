<?php

namespace App\Http\Controllers;

use App\Models\SharedDocument;
use Illuminate\Http\Request;
use App\Models\User;

class SharedDocumentController extends Controller
{
    public function index()
    {
        $receivedDocuments = SharedDocument::with('uploader')
            ->where('shared_with', auth()->id())
            ->get();
    
        $sentDocuments = SharedDocument::with('sharedWith')
            ->where('uploaded_by', auth()->id())
            ->get();
            $coaches = User::whereHas('role', function ($query) {
                $query->where('name', 'coach');
            })->get();
        
            $porteurs = User::whereHas('role', function ($query) {
                $query->where('name', 'porteur de projet');
            })->get();
    
        return view('documents.index', compact('receivedDocuments', 'sentDocuments','coaches', 'porteurs'));
    }
    

    public function create()
    {
        $coaches = User::whereHas('role', function ($query) {
            $query->where('name', 'coach');
        })->get();
    
        $porteurs = User::whereHas('role', function ($query) {
            $query->where('name', 'porteur de projet');
        })->get();
    
        return view('documents.create', compact('coaches', 'porteurs'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file',
            'shared_with' => 'nullable|array', // Permet une sélection multiple
            'shared_with.*' => 'exists:users,id', // Valide chaque ID
        ]);

        $filePath = $request->file('file')->store('shared_documents', 'public');



        $sharedWithUsers = $request->input('shared_with', []); // Récupère les utilisateurs sélectionnés

        foreach ($sharedWithUsers as $userId) {
            SharedDocument::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_path' => $filePath,
                'uploaded_by' => auth()->id(),
                'shared_with' => $userId, // Enregistre un enregistrement pour chaque utilisateur
            ]);
        }
        

        return redirect()->route('documents.index')->with('success', 'Document partagé avec succès.');
    }

    public function download($id)
    {
        $document = SharedDocument::findOrFail($id);

        // Vérifiez si l'utilisateur a accès au document
        if (
            $document->uploaded_by !== auth()->id() &&
            $document->shared_with !== auth()->id()
        ) {
            abort(403, 'Accès interdit.');
        }
        return response()->download(storage_path('app/public/' . $document->file_path));

    }

    public function destroy($id)
    {
        $document = SharedDocument::findOrFail($id);

        // Vérifiez si l'utilisateur est l'uploader
        if ($document->uploaded_by !== auth()->id()) {
            abort(403, 'Accès interdit.');
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document supprimé avec succès.');
    }
}
