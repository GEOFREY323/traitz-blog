<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('published', true)
            ->with(['user', 'tags'])
            ->latest()
            ->get();

        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
            'tags' => ['nullable', 'string'],
            'published' => ['nullable', 'boolean'],
        ]);

        // Create the post under the logged-in user
        $post = auth()->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'published' => $request->boolean('published'),
        ]);

        // Process tags
        if (!empty($validated['tags'])) {

            $tagNames = explode(',', $validated['tags']);

            $tagIds = [];

            foreach ($tagNames as $tagName) {

                $tagName = trim($tagName);

                if ($tagName === '') {
                    continue;
                }

                $name = Str::lower($tagName);
                $slug = Str::slug($tagName);

                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );

                $tagIds[] = $tag->id;
            }

            // Attach the tags to the post
            $post->tags()->sync($tagIds);
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post created successfully.');
    }
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        $post->load('tags');

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
            'tags' => ['nullable', 'string'],
            'published' => ['nullable', 'boolean'],
        ]);

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'published' => $request->boolean('published'),
        ]);

        $tagIds = [];

        if (!empty($validated['tags'])) {
            $tagNames = explode(',', $validated['tags']);

            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);

                if ($tagName === '') {
                    continue;
                }

                $name = Str::lower($tagName);
                $slug = Str::slug($tagName);

                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );

                $tagIds[] = $tag->id;
            }
        }

        $post->tags()->sync($tagIds);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Only the owner can view an unpublished draft
        if (
            !$post->published &&
            (!auth()->check() || auth()->id() !== $post->user_id)
        ) {
            abort(404);
        }

        $post->load([
            'user',
            'tags',
            'comments' => function ($query) {
                $query->with('user')->oldest();
            },
        ]);

        return view('posts.show', compact('post'));
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()
            ->where('user_id', auth()->id())
            ->with(['tags'])
            ->latest('deleted_at')
            ->get();

        return view('posts.trash', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        Gate::authorize('update', $post);

        $post->restore();

        return redirect()
            ->route('posts.trash')
            ->with('success', 'Post restored successfully.');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        Gate::authorize('delete', $post);

        $post->forceDelete();

        return redirect()
            ->route('posts.trash')
            ->with('success', 'Post permanently deleted.');
    }
}
