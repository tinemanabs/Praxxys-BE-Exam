<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function create()
    {
        return view('auth.features.products.create');
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_category' => $request->product_category,
            'product_description' => $request->product_description,
            'product_date_time' => Carbon::parse($request->product_date_time)->format('Y-m-d H:i:s')
        ]);

        if ($request->hasFile('product_images')) {
            $images = $request->file('product_images');
            foreach ($images as $img) {
                $filename = $img->hashName();

                $img->move(public_path('images/products'), $filename);

                $productImages = ProductImage::create(['filename' => $filename]);

                $product->productImages()->attach($productImages->id);
            }
        }
    }

    public function edit($id)
    {
        $product = Product::with('productImages')->find($id);
        return view('auth.features.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        Product::where('id', $id)->update([
            'product_name' => $request->product_name,
            'product_category' => $request->product_category,
            'product_description' => $request->product_description,
            'product_date_time' => Carbon::parse($request->product_date_time)->format('Y-m-d H:i:s')
        ]);

        $product = Product::find($id);

        if ($request->hasFile('product_images')) {
            $images = $request->file('product_images');
            foreach ($images as $img) {
                $filename = $img->hashName();

                $img->move(public_path('images/products'), $filename);

                $productImages = ProductImage::create(['filename' => $filename]);

                $product->productImages()->syncWithoutDetaching($productImages->id);
            }
        }
    }

    public function removeImage($id)
    {
        ProductImage::find($id)->delete();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
    }
}
