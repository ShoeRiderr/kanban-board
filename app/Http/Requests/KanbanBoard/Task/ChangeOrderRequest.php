<?php

namespace App\Http\Requests\KanbanBoard\Task;

use Illuminate\Foundation\Http\FormRequest;

class ChangeOrderRequest extends FormRequest
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
            'tasks' => ['required', 'array'],
            'tasks.*.id' => ['required', 'exists:tasks,id'],
            'tasks.*.column_id' => ['required', 'exists:columns,id'],
            'tasks.*.order' => ['required'],
        ];
    }
}
