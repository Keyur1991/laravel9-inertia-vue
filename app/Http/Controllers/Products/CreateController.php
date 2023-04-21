<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class CreateController extends Controller
{
    /**
     * Display form for product creation
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $image_path
        ]);

        return redirect('/products')->with('message', 'Product has been successfully created.');
    }
}
