<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Task;
use App\Models\Subtask;

class SubtaskController extends Controller
{

    public function index($taskId)
    {
        try {
            $task = Task::with('subtasks')->findOrFail($taskId);
    
            return response()->json([
                'task' => $task
            ]);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request, $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);
    
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);
    
            $subtask = $task->subtasks()->create($validated);
    
            return response()->json($subtask, Response::HTTP_CREATED);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($taskId, $subtaskId)
    {
        try {
            $task = Task::findOrFail($taskId,);
            $subtask = SubTask::where('id', $subtaskId)->where('task_id', $taskId)->firstOrFail();
    
            return response()->json([
                'task' => $task,
                'subtask' => $subtask
            ]);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task or Subtask not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $taskId, $subtaskId)
    {
        try {
            $task = Task::findOrFail($taskId);
            $subtask = SubTask::where('id', $subtaskId)->where('task_id', $taskId)->firstOrFail();
    
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);
    
            $subtask->update($validated);
    
            return response()->json($subtask, Response::HTTP_OK);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task or Subtask not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($taskId, $subtaskId)
    {
        try {
            $subtask = SubTask::findOrFail($subtaskId);

            $task = Task::findOrFail($taskId);

            $subtask->delete();

            return response()->json(['message' => 'Subtask deleted successfully'], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Subtask or associated task not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
