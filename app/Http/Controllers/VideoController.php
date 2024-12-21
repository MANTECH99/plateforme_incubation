<?php

// app/Http/Controllers/VideoController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        // Afficher les vidéos par catégorie
        $categories = Category::with('videos')->get();
        $videos = Video::latest()->get(); // Récupère toutes les vidéos triées par date
        return view('videos.index', compact('categories', 'videos'));
    }

    public function create()
    {
        // Formulaire de création de vidéo
        $categories = Category::all();
        return view('videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|max:2048',
            'video_path' => 'required|mimes:mp4,avi,mkv|max:20480',
            'category_id' => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
        ]);

        // Sauvegarde de la miniature et de la vidéo
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $videoPath = $request->file('video_path')->store('videos', 'public');

        // Création de la vidéo
        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'video_path' => $videoPath,
            'category_id' => $request->category_id,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('categories.index')->with('success', 'Vidéo ajoutée avec succès.');
    }

    public function show($id)
    {
        $video = Video::with('comments.replies.user', 'comments.user', 'category.videos') // Charger les relations nécessaires
                    ->findOrFail($id);

        // Récupérer uniquement les commentaires principaux
        $comments = $video->comments()->whereNull('parent_id')->get();

        return view('videos.show', compact('video', 'comments'));
    }
public function destroy($id)
{
    $video = Video::findOrFail($id); // Trouver la vidéo par son ID
    $video->delete(); // Supprimer la vidéo

    return redirect()->route('categories.show', $video->category_id)
                     ->with('success', 'Vidéo supprimée avec succès.');
}

public function edit($id)
{
    $video = Video::findOrFail($id); // Trouver la vidéo
    $categories = Category::all(); // Récupérer les catégories
    return view('videos.edit', compact('video', 'categories'));
}

public function update(Request $request, $id)
{
    $video = Video::findOrFail($id); // Trouver la vidéo à modifier

    // Validation des données
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'thumbnail' => 'nullable|image|max:2048',
        'video_path' => 'nullable|mimes:mp4,avi,mkv|max:20480',
        'category_id' => 'required|exists:categories,id',
        'published_at' => 'nullable|date',
    ]);

    // Mise à jour des champs de la vidéo
    $video->title = $request->title;
    $video->description = $request->description;
    $video->category_id = $request->category_id;
    $video->published_at = $request->published_at;

    // Si une nouvelle miniature est uploadée
    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $video->thumbnail = $thumbnailPath;
    }

    // Si une nouvelle vidéo est uploadée
    if ($request->hasFile('video_path')) {
        $videoPath = $request->file('video_path')->store('videos', 'public');
        $video->video_path = $videoPath;
    }

    $video->save(); // Enregistrer les modifications

    return redirect()->route('categories.index')->with('success', 'Vidéo mise à jour avec succès.');
}


}
