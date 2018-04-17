<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTask;
use App\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'DESC')->paginate(20);
        return view('index', compact('tasks'));
    }

    public function createTask(Request $request)
    {
        $this->validate($request, [
            'link' => 'required|url'
        ]);

        $task = Task::create([
            'link'   => $request->get('link'),
            'status' => 'pending'
        ]);

        ProcessTask::dispatch($task);

        return redirect('/');
    }

    public function taskStatuses()
    {
        $tasks = Task::orderBy('created_at', 'DESC')->paginate(20);
        return response()->json($tasks);
    }

    public function downloadFile($fileName)
    {
        $filePath = storage_path('app/downloads/' . $fileName);
        return response()->download($filePath);
    }
}
