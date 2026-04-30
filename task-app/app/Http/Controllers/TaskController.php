<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Gets only the tasks belonging to the logged-in user, newest first
        $tasks = auth()->user()->tasks()->latest()->get();
        
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        // Creates a task automatically linked to the current user's ID
        auth()->user()->tasks()->create([
            'title' => $request->title,
            'is_done' => false
        ]);

        return redirect()->back();
    }

    public function update($id)
    {
        // findOrFail here ensures a user can't toggle someone else's task by ID
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->is_done = !$task->is_done;
        $task->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        // findOrFail here ensures a user can't delete someone else's task
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();

        return redirect()->back();
    }
}