<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    /**
     * Get the tasks for the authenticated user from cache or database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTasks()
    {
        return Cache::remember('all_tasks', 60, function () {
            return Task::all(); // جلب جميع المهام
        });
    }
    /**
     * Create a new task for the authenticated user.
     *
     * @param array $data
     * @return \App\Models\Task
     */
    public function createTask(array $data)
    {
        // $task = Task::create(array_merge($data, ['user_id' => Auth::id()]));
        $task = Task::create($data);
        Cache::forget('user_tasks_' . Auth::id());
        return $task;
    }

    /**
     * Update a task.
     *
     * @param \App\Models\Task $task
     * @param array $data
     * @return \App\Models\Task
     */
    public function updateTask(Task $task, array $data)
    {
        $task->update($data);
        Cache::forget('user_tasks_' . Auth::id());
        return $task;
    }

    /**
     * Delete a task.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function deleteTask(Task $task)
    {
        $task->delete();
        Cache::forget('user_tasks_' . Auth::id());
    }
    /**
     * Get soft-deleted tasks for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTrashedTasks()
    {
        // return Task::onlyTrashed()->where('user_id', auth()->id())->get();
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return Task::onlyTrashed()->get();
    }

    /**
     * Toggle the status of a task from 'Pending' to 'Completed'.
     *
     * @param \App\Models\Task $task
     * @return bool Indicates whether the status was updated
     */
    public function toggleTaskStatus(Task $task)
    {
        if ($task->status == 'Pending') {
            $task->status = 'Completed';
            $task->save();
            return true;
        }
        return false;
    }
}
