
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trashed Tasks</h1>
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
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>
    </div>
    @if ($tasks->isEmpty())
        <p>No trashed tasks found.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->deleted_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                                </form>
                                <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
