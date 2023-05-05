<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Blog as BlogModel;

trait Blog {
    /**
     * Fetch paginated blogs
     * 
     * @param \Illuminate\Http\Request $request
     */
    private function fetchPaginatedBlogs(Request $request)
    {
        return BlogModel::query()->when($request->term, function($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                 ->orWhere('description', 'like', '%' . $search . '%');
        })->orderBy($request->sort_by ?? "created_at", $request->sort_dir ?? "desc")->paginate(15);
    }
}