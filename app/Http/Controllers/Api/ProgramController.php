<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\SubProgram;

class ProgramController extends Controller
{
    public function index()
    {
        return Program::select('id', 'nama')->get();
    }
    // Get sub-programs for a program
    public function subPrograms($id)
    {
        $program = Program::with('subPrograms')->findOrFail($id);

        return $program->subPrograms()->select(
            'id',
            'program_id',
            'name',
            'description',
            'usia',
            'slug',
        )->get();
    }

    public function showSubProgram($slug)
    {
        return SubProgram::with([
            'program:id,nama,deskripsi',
            'materis:id,sub_program_id,judul,deskripsi,urutan',
        ])
            ->where('slug', $slug)
            ->select('id', 'program_id', 'name', 'slug', 'description', 'usia')
            ->firstOrFail();
    }
}
