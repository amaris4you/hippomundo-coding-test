<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Phase;
use App\Models\Task;

class TaskController extends Controller
{

    public function kanban()
    {
        return view('tasks.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Models\Phase::with('tasks.user')->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users()
    {
        return \App\Models\User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Create a new task from the $request
        $task = Task::create($request->validated());
        $phase = Phase::find($task->phase_id);

        if ($phase) {
            $phase->increment('task_count');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->all();
        // Get the old phase_id before updating
        $oldPhaseId = $task->phase_id;

        // You can update the task's attributes with the request data
        $task->update([
            'name' => $data['name'],
            'phase_id' => $data['phase_id'],
            'user_id' => $data['user_id'],
        ]);

        // Check if the new phase's status is 1 and the task is not completed
        $newPhase = Phase::find($data['phase_id']);
        if ($newPhase && $newPhase->status == 1 && is_null($task->completed_at)) {
            $task->update(['completed_at' => now()]);
        }

        // Check if the old phase exists and decrement its task_count
        if ($oldPhaseId !== $data['phase_id']) {
            $oldPhase = Phase::find($oldPhaseId);
            if ($oldPhase) {
                $oldPhase->decrement('task_count');
            }
        }

        // Increment the task_count of the new phase
        $newPhase = Phase::find($data['phase_id']);
        if ($newPhase) {
            $newPhase->increment('task_count');
        }

        return response()->json(['message' => 'Task updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $phaseId = $task->phase_id;

        // Ensure that the task exists
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Delete the task
        $task->delete();

        // Update the task_count in the phases table for the associated phase
        $phase = Phase::find($phaseId);

        if ($phase) {
            $phase->decrement('task_count');
        }
        
        return response()->json(['message' => 'Task deleted']);
    }
}
