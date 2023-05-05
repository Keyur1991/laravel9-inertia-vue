<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Traits\Blog as BlogTrait;

class BlogController extends Controller
{
    use BlogTrait;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request) : Response
    {
        return Inertia::render('Blog/Listing', [
            'blogs' => $this->fetchPaginatedBlogs($request),
            'search' => $request->term ?? '',
            'search' => $request->term ?? '',
            'sortBy' => $request->sort_by ?? 'created_at',
            'sortDir' => $request->sort_dir ?? 'desc'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create() : Response
    {
        return Inertia::render('Blog/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BlogRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogRequest $request) : RedirectResponse
    {
        $blog = Blog::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect(route('blog.index'))->with('message', __("messages.blog.created"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Inertia\Response
     */
    public function show(Blog $blog) : Response
    {
        return Inertia::render('Blog/Show', [
            'blog' => $blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Inertia\Response
     */
    public function edit(Blog $blog) : Response
    {
        return Inertia::render('Blog/Edit', [
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BlogRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function update(BlogRequest $request, Blog $blog) : RedirectResponse
    {
        $blog->name = $request->name;
        $blog->description = $request->description;

        return redirect(route('blog.index'))->with('message', __("messages.blog.updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->posts()->delete();
        
        $blog->delete();

        return redirect(route('blog.index'))->with('message_danger', __("messages.blog.deleted"));
    }
}
