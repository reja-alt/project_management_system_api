<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json($project);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $project->update($validated);

            return response()->json($project, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);

            $project->delete();

            return response()->json(['message' => 'Project deleted successfully'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }
    }

    public function generateReport($projectId)
    {
        try {
            $project = Project::with('tasks.subtasks')->findOrFail($projectId);

            $reportData = [
                'project' => [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                    'tasks' => $project->tasks->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'name' => $task->name,
                            'description' => $task->description,
                            'subtasks' => $task->subtasks->map(function ($subtask) {
                                return [
                                    'id' => $subtask->id,
                                    'name' => $subtask->name,
                                    'description' => $subtask->description,
                                ];
                            }),
                        ];
                    }),
                ],
            ];

            return response()->json($reportData, Response::HTTP_OK);

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
}
