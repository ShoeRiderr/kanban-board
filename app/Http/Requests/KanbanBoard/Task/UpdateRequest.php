<?php

namespace App\Http\Requests\KanbanBoard\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes'],
            'description' => ['nullable'],
            'estimation' => ['nullable'],
            'order' => ['sometimes', 'numeric'],
            'due_date' => ['sometimes', 'date'],
            'column_id' => ['sometimes', 'exists:columns,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'exists:tags,id'],
            'files' => ['nullable', 'array'],
            'files.*' => ['required'],
        ];
    }
}
