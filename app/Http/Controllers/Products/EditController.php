<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class EditController extends Controller
{
    /**
     * Show form to update product
     * 
     * @param int $id
     */
    public function edit(int $id) : Response
    {
        return Inertia::render('Products/Edit', [
            'product' => Product::find($id) 
        ]);
    }

    /**
     * Update a product
     * 
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, int $id) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $product = Product::find($id);

        $product->name = $request->name;
        $product->category = $request->category;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('image', 'public');
        }

        $product->save();

        return redirect('/products')->with('message', 'Product has been successfully updated.');
    }
}
