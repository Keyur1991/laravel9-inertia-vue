<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Storage;

class DeleteController extends Controller
{
    /**
     * Soft delete a product
     * 
     * @param int $id
     */
    public function destroy(int $id) : RedirectResponse
    {
        $product = Product::find($id);

        if ($product->image != '' && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        Product::find($id)->delete();

        return redirect('/products')->with('message', 'Product has been successfully deleted.');
    }
}
