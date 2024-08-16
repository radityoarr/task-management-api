<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaskDetailResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        // return response()->json(['data'=>$post]);
        return TaskResource::collection($tasks);
    }

    public function show($id)
    {
        $task = Task::with(['user:id,name','project:id,name'])->findOrFail($id);
        return new TaskDetailResource($task);
        
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name'        => 'required|string',
            'description' => 'required|string',
            'start_date'  => 'required|date_format:Y-m-d',
            'end_date'    => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'user_id'     => 'required|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }

        $data = $validated->validated();

        try {
            $task = Task::create($data);
            return response()->json(['message' => 'Task created successfully!'], 201);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json(['error' => 'A task with this user ID already exists.'], 409);
            }
        }
    }
    

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name'        => 'string',
            'description' => 'string',
            'start_date'  => 'date_format:Y-m-d',
            'end_date'    => 'date_format:Y-m-d|after_or_equal:start_date',
            'user_id'     => 'exists:users,id',
            'project_id'  => 'exists:projects,id',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }

        $data = $validated->validated();

        
        try {
            $task = Task::findOrFail($id); 
            $task->update($data);
            return response()->json(['message' => 'Task updated successfully!'], 200);

        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json(['error' => 'A task with this user ID already exists.'], 409);
            }
            return response()->json(['error' => 'An error occurred while updating the task.'], 500);
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        
    }
    

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
