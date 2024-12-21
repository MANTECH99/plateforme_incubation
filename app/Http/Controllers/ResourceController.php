<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Notifications\ImportantAlertNotification;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller
{
    public function index()
    {
        $documents = Resource::where('type', 'document')->paginate(6);  // 6 documents par page
        $formations = Resource::where('type', 'formation')->paginate(6);  // 6 formations par page
        $tools = Resource::where('type', 'outil')->paginate(6);  // 6 outils par page
        
        return view('resources.index', compact('documents', 'formations', 'tools'));
    }
    
    public function download($id)
    {
        $resource = Resource::findOrFail($id);
    
        // Vérifie si le fichier existe dans le dossier public/storage
        $filePath = storage_path('app/public/' . $resource->file_path);
    
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Fichier non trouvé.');
        }
    }
    

    
    public function create()
{
    return view('resources.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|string|in:document,formation,outil',
        'file' => 'required|file',
    ]);

    // Déplace le fichier dans le dossier public/resources
    $filePath = $request->file('file')->storeAs('resources', $request->file('file')->getClientOriginalName(), 'public');

    // Crée une nouvelle ressource avec le chemin relatif du fichier
    $resource = Resource::create([
        'title' => $validated['title'],
        'description' => $request->description,
        'type' => $validated['type'],
        'file_path' => $filePath, // Le chemin du fichier dans le dossier public
    ]);

    // Récupérez tous les utilisateurs
    $users = User::all();

    // Créez une notification pour chaque utilisateur
    foreach ($users as $user) {
        $user->notify(new ImportantAlertNotification(
            'Nouvelle Ressource Disponible',
            "Une nouvelle ressource '{$resource->title}' est disponible.",
            route('resources.index'),
            'ressource'
        ));
    }

    return redirect()->route('resources.index')->with('success', 'Ressource ajoutée avec succès et notification envoyée.');
}



public function edit($id)
{
    $resource = Resource::findOrFail($id);
    return view('resources.edit', compact('resource'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|string|in:document,formation,outil',
        'file' => 'nullable|file',
        'description' => 'nullable|string|max:1000',
    ]);

    $resource = Resource::findOrFail($id);

    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('resources');
        $resource->file_path = $filePath;
    }

    $resource->update([
        'title' => $validated['title'],
        'description' => $request->description,
        'type' => $validated['type'],
    ]);

    return redirect()->route('resources.index')->with('success', 'Ressource mise à jour avec succès.');
}

public function destroy($id)
{
    $resource = Resource::findOrFail($id);
    $resource->delete();

    return redirect()->route('resources.index')->with('success', 'Ressource supprimée avec succès.');
}


public function show($filename)
{
    $path = storage_path("app/private/private/resources/{$filename}");

    // Vérifie si le fichier existe dans le dossier privé
    if (!Storage::exists("private/private/resources/{$filename}")) {
        abort(404, 'Fichier non trouvé');
    }

    // Retourne le fichier pour affichage
    return response()->file($path);
}
    
}
