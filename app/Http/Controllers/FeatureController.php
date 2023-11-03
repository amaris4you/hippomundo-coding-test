<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    public function show()
    {
        // Calculate the start and end of the current week
        $currentWeekStart = now()->startOfWeek(); // Adjust to your application's timezone
        $currentWeekEnd = now()->endOfWeek();     // Adjust to your application's timezone

        // Query the tasks table
        $completedThisWeek = DB::table('tasks')
            ->whereNotNull('completed_at') // Only consider completed tasks
            ->whereBetween('completed_at', [$currentWeekStart, $currentWeekEnd])
            ->count();
        // Get the current year and month
        $currentYear = now()->year; // Adjust to your application's timezone
        $currentMonth = now()->month; // Adjust to your application's timezone

        // Query the tasks table
        $completedThisMonth = DB::table('tasks')
            ->whereNotNull('completed_at') // Only consider completed tasks
            ->whereYear('completed_at', $currentYear)
            ->whereMonth('completed_at', $currentMonth)
            ->count();
        // Query the tasks and users tables, and group by user_id
        $assignedTasksPerUser = Task::join('users', 'tasks.user_id', '=', 'users.id')
        ->select('users.name', 'tasks.user_id', DB::raw('count(*) as total_assigned'))
        ->groupBy('users.name', 'tasks.user_id')
        ->get();
        return view('feature.show', compact('completedThisWeek', 'completedThisMonth', 'assignedTasksPerUser'));
    }
    public function create()
    {
        $phases = Phase::all();
        return view('feature.create', compact('phases'));
    }

    public function update(Request $request) {
        $phaseIds = $request->input('phases', []); // Get the selected phase IDs from the form
        // Update the status for selected phases to 1, and set status to 0 for others
        Phase::query()
            ->update([
                'status' => DB::raw('CASE WHEN id IN (' . implode(',', $phaseIds) . ') THEN 1 ELSE 0 END')
            ]);
        // Redirect back or to another page after the update
        return redirect()->back();
    }
}
