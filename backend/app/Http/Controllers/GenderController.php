<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genders = Gender::where('statusenabled', true)->get();
        return GenderResource::collection($genders);
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
            'genre_name' => 'required|max:255',
        ]);
        DB::beginTransaction();
        try {
            Gender::create([
                'statusenabled' => true,
                'genre_name' => $request->genre_name,
            ]);
            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Gender berhasil ditambahkan'
            ], 201);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Gender gagal ditambahkan',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show(Gender $gender, $id)
    {
        $gender = Gender::where('id', $id)
        ->where('statusenabled', true)
        ->first();
        $to_array = (array) $gender;

        if (count($to_array) > 0) {
            return response()->json([
                'message' => "Data Berhasil Ditemukan",
                'data' => new GenderResource($gender)
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
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function edit(Gender $gender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gender $gender)
    {
        $request->validate([
            'genre_name' => 'required|max:255',
        ]);
        DB::beginTransaction();

        try {
            Gender::where('id', $request->id)->update([
                'genre_name' => $request->genre_name
            ]);
            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Gender berhasil diubah'
            ], 201);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Gender gagal diubah',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gender $gender, $id)
    {
        DB::beginTransaction();
        try {
            Gender::where('id', $id)->update([
                'statusenabled' => false
            ]);

            $status_code = true;
        } catch (\Throwable $th) {
            $status_code = false;
        }

        if ($status_code) {
            DB::commit();
            return response()->json([
                'message' => 'Gender berhasil dihapus'
            ], 200);
        } else {
            DB::rollBack();  
            return response()->json([
                'message' => 'Gender gagal dihapus',
            ], 400);
        }
    }
}
