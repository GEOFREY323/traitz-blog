@extends('layouts.app')

@section('title', 'Latest Posts')

@section('content')

<main class="page">
  <div class="container">

    <div class="page-header">
      <div>
        <h1>Latest Posts</h1>
        <p>Articles from the Traitz Academy community.</p>
      </div>
    </div>

    <div class="layout-with-sidebar">

      <!-- ================= POST LIST ================= -->

      <div class="post-list">

        @forelse ($posts as $post)

          <article class="post-card">

            <h2>
              <a href="{{ route('posts.show', $post) }}">
                  {{ $post->title }}
              </a>

              @if(!$post->published)
                <span class="badge-draft">Draft</span>
              @endif
            </h2>

            <p class="post-meta">

              By <strong>{{ $post->user->name }}</strong>

              <span class="dot">&bull;</span>

              <span>
                {{ $post->created_at->diffForHumans() }}
              </span>

            </p>

            <p class="post-excerpt">
              {{ Str::limit($post->body, 180) }}
            </p>

            <div class="tag-list">

              @foreach ($post->tags as $tag)

                <<a
                    href="{{ route('tags.show', $tag->slug) }}"
                    class="tag">
                    #{{ $tag->name }}
                  </a>

              @endforeach

            </div>

          </article>

        @empty

          <div class="empty-state">
            <p>
              No posts have been published yet. Check back soon.
            </p>
          </div>

        @endforelse

      </div>


      <!-- ================= SIDEBAR ================= -->

      <aside>

        <div class="sidebar-box">

          <h3>Browse by Tag</h3>

          <div class="tag-cloud">

            @foreach ($tags as $tag)

              <a href="#" class="tag-pill">
                #{{ $tag->name }}
              </a>

            @endforeach

          </div>

        </div>


        <div class="sidebar-box">

          <h3>About This Blog</h3>

          <p style="font-size: 14px; color: var(--text-muted); margin: 0;">

            A practice project built by Traitz Academy interns while learning
            routing, Blade, Eloquent relationships, validation, and
            authentication.

          </p>

        </div>

      </aside>

    </div>
  </div>
</main>

@endsection