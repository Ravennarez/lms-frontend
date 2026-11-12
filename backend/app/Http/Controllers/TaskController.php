<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. Get all tasks
    public function index()
    {
        return response()->json(Task::all());
    }

    // 2. Add a new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status ?? 'pending',
        ]);

        return response()->json($task, 201);
    }

    // 3. Update task status/details
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        
        // Validate optional incoming fields
        $request->validate([
            'title'  => 'sometimes|string|max:255',
            'status' => 'sometimes|in:pending,completed',
        ]);

        $task->update($request->only(['title', 'status']));

        return response()->json($task, 200);
    }

    // 4. Delete a task
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}