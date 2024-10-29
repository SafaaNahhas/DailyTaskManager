<?php

namespace App\Http\Controllers\Task;

use Mail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Mail\PendingTasksMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\TaskRequest\StoreTaskRequest;
use App\Http\Requests\TaskRequest\UpdateTaskRequest;

class TaskController extends Controller
{

    protected $taskService;

    /**
     * Constructor to initialize TaskService.
     *
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the user's tasks.
     *
     * @return \Illuminate\View\View
     */
   
    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created task in storage.
     *
     * @param \App\Http\Requests\TaskRequest\StoreTaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskRequest $request)
    {
        // $this->taskService->createTask($request->validated());
        $this->taskService->createTask($request->validated() + ['user_id' => $request->user_id]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit',  compact('task', 'users'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param \App\Http\Requests\TaskRequest\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {    $data = array_merge($request->validated(), ['user_id' => $request->input('user_id')]);

        $this->taskService->updateTask($task,   $data);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $this->taskService->deleteTask($task);
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    /**
 * Display a listing of soft-deleted tasks.
 *
 * @return \Illuminate\View\View
 */
public function trashedTasks()
{
    $tasks = $this->taskService->getTrashedTasks();
    return view('tasks.trashed', compact('tasks'));
}

/**
 * Restore a soft-deleted task.
 *
 * @param Task $task
 * @return \Illuminate\Http\RedirectResponse
 */

public function restoreTask($id)
{
    $task = Task::withTrashed()->findOrFail($id);
    $task->restore();
    Cache::forget('user_tasks_' . Auth::id());


    return redirect()->route('tasks.index')->with('success', 'Task restored successfully.');
}
/**
 * Permanently delete a soft-deleted task.
 *
 * @param Task $task
 * @return \Illuminate\Http\RedirectResponse
 */



public function forceDeleteTask($id)
{
    $task = Task::withTrashed()->findOrFail($id);
    $task->forceDelete();
    Cache::forget('user_tasks_' . Auth::id());

    return redirect()->route('tasks.trashed')->with('success', 'Task permanently deleted.');
}
    /**
     * Toggle the status of the specified task.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Task $task)
    {
        $statusUpdated = $this->taskService->toggleTaskStatus($task);
        Cache::forget('user_tasks_' . Auth::id());
        $message = $statusUpdated ? 'Task marked as completed successfully.' : 'Task status cannot be changed back to pending.';
        return redirect()->route('tasks.index')->with($statusUpdated ? 'success' : 'error', $message);
    }
}
