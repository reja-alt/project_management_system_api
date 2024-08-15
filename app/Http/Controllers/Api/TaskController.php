<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function index($projectId)
    {
        try {
            $project = Project::with('tasks')->findOrFail($projectId);
    
            return response()->json([
                'project' => $project
            ]);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request, $projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
    
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);
    
            $task = $project->tasks()->create($validated);
    
            return response()->json($task, Response::HTTP_CREATED);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($projectId, $taskId)
    {
        try {
            $project = Project::findOrFail($projectId);
            $task = Task::where('id', $taskId)->where('project_id', $project->id)->firstOrFail();
    
            return response()->json([
                'project' => $project,
                'task' => $task
            ]);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project or task not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $projectId, $taskId)
    {
        try {
            $project = Project::findOrFail($projectId);
            $task = Task::where('id', $taskId)->where('project_id', $project->id)->firstOrFail();
    
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);
    
            $task->update($validated);
    
            return response()->json($task, Response::HTTP_OK);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project or task not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy($projectId, $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            $project = Project::findOrFail($projectId);

            $task->delete();

            return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task or associated project not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
