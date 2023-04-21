<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ListingController extends Controller
{
    /**
     * Show listing of the products
     * 
     * @param Request $request
     */
    public function index(Request $request)
    {
        return Inertia::render('Products/Listing', [
            'products' => Product::query()->when($request->term, function($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                     ->orWhere('category', 'like', '%' . $search . '%')
                     ->orWhere('description', 'like', '%' . $search . '%');
            })->orderBy('created_at', 'desc')->paginate(10),
            'search' => $request->term ?? ''
        ]);
    }
}
