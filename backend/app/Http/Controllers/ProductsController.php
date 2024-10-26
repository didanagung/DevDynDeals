<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailProductResource;
use App\Http\Resources\ProductsResource;
use App\Models\DetailProduct;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index() {
        $products = Products::where('statusenabled', true)->get();
        // return response()->json($products);
        return ProductsResource::collection($products);
    }

    public function show($id) {
        $product = Products::with(['detailProducts:id,statusenabled,product_id'])->findOrFail($id);
        return new DetailProductResource($product);
    }

    public function store(Request $request) {
        $image_data = file_get_contents($request->file);
        $base64 = base64_encode($image_data );
        return $base64;
        $request->validate([
            'name' => 'required|max:255',
            'short_description' => 'required|max:100',
            'description' => 'required',
            'color_id' => 'required',
            'size_id' => 'required',
            'qty_product' => 'required',
            'gender_id' => 'required',
        ]);

        // if ($request->file) {
        //     $file_name = $this->generateRandomString();
        //     $extension = $request->file->extension();

        //     Storage::putFileAs('images', );
        // }
        DB::beginTransaction();
        try {
            $produk = Products::create([
                'id' => Str::uuid(),
                'statusenabled' => true,
                'name' => $request->name,
                'short_description' => $request->short_description,
                'description' => $request->description
            ]);
    
            DetailProduct::create([
                'id' => Str::uuid(),
                'statusenabled' => true,
                'product_id' => $produk->id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'gender_id' => $request->gender_id,
                'qty_product' => (int) $request->qty_product
            ]);

            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Produk berhasil ditambahkan'
            ], 201);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Produk gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request) {
        $data_old_product = Products::find($request->id);
        $request->validate([
            'name' => 'required|max:255',
            'short_description' => 'required|max:100',
            'description'    => 'required',
            'color_id'    => 'required',
            'size_id'       => 'required',
            'qty_product'     => 'required',
        ]);
        DB::beginTransaction();
        try {
            DetailProduct::where('product_id', $data_old_product->id)->update([
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'gender_id' => $request->gender_id,
                'qty_product' => $request->qty_product
            ]);

            Products::where('id', $request->id)->update([
                'name' => $request->name,
                'short_description' => $request->short_description,
                'description' => $request->description
            ]);

            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Produk berhasil diedit'
            ], 200);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Produk gagal diedit',
            ], 400);
        }
    }

    public function destroy(Request $request) {
        // soft delete ala ala
        // $data_old_product = Products::find($request->id);
        DB::beginTransaction();
        try {
            DetailProduct::where('product_id', $request->id)->update([
                'statusenabled' => false
            ]);

            Products::where('id', $request->id)->update([
                'statusenabled' => false
            ]);

            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ], 200);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Produk gagal dihapus',
            ], 400);
        }
    }

    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
}
