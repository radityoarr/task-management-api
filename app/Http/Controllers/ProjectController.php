<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProjectDetailResource;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        // return response()->json(['data'=>$post]);
        return ProjectResource::collection($projects);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return new ProjectDetailResource($project);
        
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name'        => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }


        $project = Project::create([
            'name'     => $request->name,
            'description'   => $request->description,
            'start_date'   => $request->start_date,
            'end_date'   => $request->end_date
        ]);

        return new ProjectDetailResource($project);

    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name'        => 'string',
            'description' => 'string',
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d|after_or_equal:start_date'
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }

        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->update($request->only(['name', 'description', 'start_date', 'end_date']));

        return new ProjectDetailResource($project);
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }


}
