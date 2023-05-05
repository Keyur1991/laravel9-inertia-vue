<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Blog;

trait Post {
    /**
     * Fetch paginated posts of a blog
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Blog $blog
     */
    private function fetchPaginatedPosts(Request $request, Blog $blog)
    {
        return $blog->posts()->when($request->term, function($query, $search) {
                    $query->where("title", "like", "%" . $search . "%")
                        ->orWhere("content", "like", "%" . $search . "%");
                })->where('blog_id', $blog->id)
                ->orderBy($request->sort_by ?? "created_at", $request->sort_dir ?? "desc")
                ->paginate(15);
    }

    /**
     * Upload post image 
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    private function uploadPostImage(Request $request) : string
    {
        $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
        }
        return $image_path;
    }
}