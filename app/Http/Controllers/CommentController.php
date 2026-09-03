<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        if (!$post->published) {
            abort(403);
        }

        $post->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Comment posted successfully.');
    }
}

