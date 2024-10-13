<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailProductResource;
use App\Http\Resources\ProductsResource;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index() {
        $products = Products::all();
        // return response()->json($products);
        return ProductsResource::collection($products);
    }

    public function show($id) {
        $product = Products::with(['detailProducts:id,statusenabled,product_id'])->findOrFail($id);
        return new DetailProductResource($product);
    }
}
