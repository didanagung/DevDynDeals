<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use App\Http\Requests\StoreColorsRequest;
use App\Http\Requests\UpdateColorsRequest;
use App\Http\Resources\ColorResource;
use Illuminate\Support\Facades\DB;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Colors::where('statusenabled', true)->get();
        return ColorResource::collection($colors);
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
     * @param  \App\Http\Requests\StoreColorsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreColorsRequest $request)
    {
        $request->validate([
            'color_name' => 'required|max:255',
        ]);
        DB::beginTransaction();
        try {
            Colors::create([
                'statusenabled' => true,
                'color_name' => $request->color_name,
            ]);
            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Warna berhasil ditambahkan'
            ], 201);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Warna gagal ditambahkan',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function show(Colors $colors, $id)
    {
        $color = Colors::where('id', $id)->first();
        $to_array = (array) $color;

        if (count($to_array) > 0) {
            return response()->json([
                'message' => "Data Berhasil Ditemukan",
                'data' => new ColorResource($color)
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
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function edit(Colors $colors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateColorsRequest  $request
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColorsRequest $request, Colors $colors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colors $colors)
    {
        //
    }
}
