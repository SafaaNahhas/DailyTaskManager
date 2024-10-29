@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Task</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="user_id">Assign to User:</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    @if($user->id !== 1)
                    <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected' : '' }}>
                        {{ $user->id }}
                    </option>
                    @endif
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
