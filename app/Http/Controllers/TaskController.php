<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ]);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>['required','string','max:150'],
            'description'=>['nullable','string'],
            'status'=>['required','in:pending,in_progress,completed'],
            'priority'=>['required','in:low,medium,high'],
            'due_date'=>['nullable','date'],
        ]);
        
        $validated['user_id']=Auth::id();

        Task::create($validated);

        return redirect()->route('tasks.index');
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
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'=>['sometimes','required','string','max:150'],
            'description'=>['nullable','string'],
            'status'=>['sometimes','required','in:pending,in_progress,completed'],
            'priority'=>['sometimes','required','in:low,medium,high'],
            'due_date'=>['nullable','date'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
