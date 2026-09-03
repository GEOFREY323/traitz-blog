<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->where('published', true)
            ->with(['user', 'tags'])
            ->latest()
            ->get();

        return view('tags.show', compact('tag', 'posts'));
    }
}