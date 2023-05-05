<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use App\Traits\Post as PostTrait;

class PostController extends Controller
{
    use PostTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Blog $blog
     * @return \Inertia\Response
     */
    public function index(Request $request, Blog $blog) : Response
    {
        return Inertia::render('Post/Listing', [
            'blog' => $blog,
            'posts' => $this->fetchPaginatedPosts($request, $blog),
            'search' => $request->term ?? '',
            'sortBy' => $request->sort_by ?? 'created_at',
            'sortDir' => $request->sort_dir ?? 'desc'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Blog $blog
     * @return \Inertia\Response
     */
    public function create(Blog $blog) : Response
    {
        return Inertia::render('Post/Create', [
            'blog' => $blog
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Blog $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request, Blog $blog) : RedirectResponse
    {
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $this->uploadPostImage($request),
            'user_id' => auth()->user()->id,
            'blog_id' => $blog->id
        ]);

        return redirect(route('blog.post.index', $blog->id))->with('message', __('messages.blog.post.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @return \Inertia\Response
     */
    public function show(Blog $blog, Post $post) : Response
    {
        $post->upvotes;
        $post->downvotes;

        return Inertia::render('Post/Show', [
            'blog' => $blog,
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @return \Inertia\Response
     */
    public function edit(Blog $blog, Post $post) : Response
    {
        return Inertia::render('Post/Edit', [
            'blog' => $blog,
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, Blog $blog, Post $post) : RedirectResponse
    {
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $post->image = $this->uploadPostImage($request);
        }

        $post->save();

        return redirect(route('blog.post.index', $blog->id))->with('message', __('messages.blog.post.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog $blog
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Blog $blog, Post $post) : RedirectResponse
    {
        $post->delete();

        return redirect(route('blog.post.index', $blog->id))->with('message_danger', __('messages.blog.post.deleted'));
    }

    /**
     * Get the popular posts based on number of posts requested
     * 
     * @param \Illuminate\Http\Request $request
     * @param int|null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function popular(Request $request, int $id = null) : JsonResponse
    {
        $posts = Post::leftjoin('votes', 
                        function($join) {
                                $join->on('votes.votable_id', '=', 'posts.id')
                                    ->where('votes.votable_type', Post::class); 
                        }
                    )->select(['posts.title', 'posts.content', 'posts.id', 'posts.image', 'posts.blog_id', \DB::raw('sum(votes.value) as votes')])
                    ->when($id, function($query, $id) {
                        $query->where('posts.blog_id', $id);
                    })
                    ->orderBy('votes', 'desc')
                    ->groupBy('posts.id')
                    ->limit($request->limit)
                    ->get();

        return response()->json($posts);
    }
}
