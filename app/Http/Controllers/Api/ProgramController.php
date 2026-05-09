<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\SubProgram;

class ProgramController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PROGRAM LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return Program::select(
            'id',
            'nama',
            'deskripsi',
            'image_url'
        )->get();
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PROGRAM
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        return Program::select(
            'id',
            'nama',
            'deskripsi',
            'image_url'
        )->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | SUB PROGRAMS BY PROGRAM
    |--------------------------------------------------------------------------
    */

    public function subPrograms($id)
    {
        return SubProgram::where(
                'program_id',
                $id
            )
            ->select(
                'id',
                'program_id',
                'name',
                'slug',
                'description',
                'usia',
                'harga',
                'image_url'
            )
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL SUB PROGRAM
    |--------------------------------------------------------------------------
    */

    public function showSubProgram($slug)
    {
        return SubProgram::with([

                'program:id,nama,deskripsi,image_url',

                'materis:id,sub_program_id,judul,deskripsi,urutan',

            ])
            ->where('slug', $slug)

            ->select(
                'id',
                'program_id',
                'name',
                'slug',
                'description',
                'usia',
                'harga',
                'image_url'
            )

            ->firstOrFail();
    }
}
