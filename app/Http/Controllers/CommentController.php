<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $videoId)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id', // Valider la relation parent_id
        ]);
    
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id();
        $comment->video_id = $videoId;
    
        if ($request->has('parent_id')) {
            $comment->parent_id = $request->input('parent_id');
        }
    
        $comment->save();
    
        return redirect()->route('videos.show', $videoId);
    }
    
}
