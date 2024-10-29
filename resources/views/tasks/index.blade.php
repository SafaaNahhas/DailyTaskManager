@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daily Tasks</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="mb-3">
        @can('create tasks')
        <a href="{{ route('tasks.create') }}" class="btn btn-primary  me-2">Add New Task</a>
        @endcan
        @can('view trashed tasks')
        <a href="{{ route('tasks.trashed') }}" class="btn btn-secondary">View Trashed Tasks</a>
        @endcan

    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @can('edit tasks')
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm mb-2">Edit</a>
                                @endcan

                                @can('delete tasks')
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-2">Delete</button>
                                </form>
                                @endcan

                                @can('edit tasks')
                                <form action="{{ route('tasks.toggleStatus', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        {{ $task->status == 'Pending' ? 'Mark as Completed' : 'Task Completed' }}
                                    </button>
                                </form>
                                @endcan

                            </div>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
