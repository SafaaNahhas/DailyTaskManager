@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Task</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date:</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
        </div>
        <div class="form-group">
            <label for="user_id">Assign to User:</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    @if($user->id !== 1)
                        <option value="{{ $user->id }}">{{ $user->id }}</option>
                    @endif
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
</div>
@endsection
