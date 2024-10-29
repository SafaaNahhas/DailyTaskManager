<?php

namespace App\Http\Requests\TaskRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|max:50|unique:tasks,title,' . $this->task->id,
            'due_date' => 'nullable|after_or_equal:today',
            'description' => 'nullable|max:200|string',
            'user_id' => 'nullable|exists:users,id',

             ];
    }
}
