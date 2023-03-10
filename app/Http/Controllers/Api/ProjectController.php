<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all()/* with('type', 'technologies')->paginate(10) */;

        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }

    public function show($slug)
    {
        $project = Project::with('types', 'technologies')->where('slug', $slug)->first();

        if ($project) {
            return response()->json([
                'success' => true,
                'post' => $project
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Nessun Progetto Trovato'
            ]);
        }
    }
}
