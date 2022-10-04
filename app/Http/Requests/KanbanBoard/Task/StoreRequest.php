<?php

namespace App\Http\Requests\KanbanBoard\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['nullable'],
            'order' => ['sometimes', 'numeric'],
            'column_id' => ['required', 'exists:columns,id'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'project_id' => ['sometimes', 'exists:projects,id'],
        ];
    }
}
