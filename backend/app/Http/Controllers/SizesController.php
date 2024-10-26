<?php

namespace App\Http\Controllers;

use App\Http\Resources\SizeResource;
use App\Models\Sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Sizes::where('statusenabled', true)->get();
        return SizeResource::collection($sizes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'size_name' => 'required|max:5',
        ]);
        DB::beginTransaction();
        try {
            Sizes::create([
                'statusenabled' => true,
                'size_name' => strtoupper($request->size_name)
            ]);
            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Ukuran berhasil ditambahkan'
            ], 201);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Ukuran gagal ditambahkan',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function show(Sizes $sizes, $id)
    {
        $size = Sizes::where('id', $id)
        ->where('statusenabled', true)
        ->first();
        $to_array = (array) $size;

        if (count($to_array) > 0) {
            return response()->json([
                'message' => "Data Berhasil Ditemukan",
                'data' => new SizeResource($size)
            ], 200);
        } else {
            return response()->json([
                'message' => "Data Tidak Ditemukan",
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function edit(Sizes $sizes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sizes $sizes)
    {
        $request->validate([
            'size_name' => 'required|max:5',
        ]);
        DB::beginTransaction();

        try {
            Sizes::where('id', $request->id)->update([
                'size_name' => strtoupper($request->size_name)
            ]);
            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Ukuran berhasil diubah'
            ], 201);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Ukuran gagal diubah',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sizes $sizes, $id)
    {
        DB::beginTransaction();
        try {
            Sizes::where('id', $id)->update([
                'statusenabled' => false
            ]);

            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Ukuran berhasil dihapus'
            ], 200);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Ukuran gagal dihapus',
            ], 400);
        }
    }
}
