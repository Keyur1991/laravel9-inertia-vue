<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Blog $blog, Post $post)
    {
        return Vote::with('user')
                    ->votable(Post::class, $post->id)
                    ->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function create(Blog $blog, Post $post)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Blog $blog, Post $post)
    {
        Vote::updateOrCreate(
            ['user_id' => auth()->user()->id, 'votable_type' => Post::class, 'votable_id' => $post->id],
            ['value' => $request->vote]
        );
        
        return redirect(route('blog.post.show', [$blog->id, $post->id]))->with("message", __("messages.blog.post.vote.saved"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog, Post $post, Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog, Post $post, Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog, Post $post, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post $post
     * @param  \App\Models\Vote $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog, Post $post, Vote $vote)
    {
        //
    }
}
