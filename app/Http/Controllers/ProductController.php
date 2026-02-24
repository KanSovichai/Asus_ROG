<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //

    public function formDataProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'nullable',
            'description' => 'required',
            'cpu' => 'nullable',
            'gpu' => 'nullable',
            'ram' => 'nullable',
            'display' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'stock' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $file = $request->file('image');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('images', $imageName, 'public');
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'cpu' => $request->cpu,
            'gpu' => $request->gpu,
            'ram' => $request->ram,
            'display' => $request->display,
            'price' => $request->price,
            'image' => $imageName,
            'stock' => $request->stock ?? 0,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
        ], 201);
    }

    function getProductData()
    {
        $products = Product::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'description' => $product->description,
                'cpu' => $product->cpu,
                'gpu' => $product->gpu,
                'ram' => $product->ram,
                'display' => $product->display,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'image_url' => url('storage/images/' . $product->image), // Build URL here
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });
        return response()->json([
            'status' => 'success',
            'products' => $products,
        ], 200);
    }

    function deleteProduct($id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ], 200);
    }

    function editProduct($id){
        $product = Product::findOrFail($id);
        if(!$product){
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        $product->image_url = url('storage/images/' . $product->image);
        return response()->json([
            'status' => 'success',
            'product' => $product,
        ],200);
    }
    function updateProduct(Request $request, $id){
        $product = Product::findOrFail($id);
        if(!$product){
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'nullable',
            'description' => 'required',
            'cpu' => 'nullable',
            'gpu' => 'nullable',
            'ram' => 'nullable',
            'display' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'stock' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $imageName, 'public');
            $product->image = $imageName;
        }
        $product->name = $request->name;
        $product->category = $request->category;
        $product->description = $request->description;
        $product->cpu = $request->cpu;
        $product->gpu = $request->gpu;
        $product->ram = $request->ram;
        $product->display = $request->display;
        $product->price = $request->price;
        $product->stock = $request->stock ?? 0;
        $product->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
        ], 200);
    }
}
