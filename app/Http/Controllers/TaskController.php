<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $query = Task::where('created_by', $userId);

        if(request('from') && request('to')) {
            if (request('from') > request('to') || request('from') == request('to') ) {
                return redirect()->back()->with('error', 'Invalid date range');
            }
            $query->whereBetween('date', [request('from'), request('to')]);
        }

        if (request('action') === 'clear') {
            return redirect()->route('dashboard');
        }

        $task = $query->orderBy('date', 'desc')->get();

        return view('dashboard', compact('task'));
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $isLoading = false;

        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|in:1,2,3',
            'date' => 'required|date',
        ]);

        Task::create([
            'name' => $request->name,
            'priority' => $request->priority,
            'date' => $request->date,
            'created_by' => $userId,
        ]);



        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|in:1,2,3',
            'date' => 'required|date',
        ]);

        $task->update([
            'name' => $request->name,
            'priority' => $request->priority,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function marking(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }
}
