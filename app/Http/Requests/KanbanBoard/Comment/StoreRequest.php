<?php

namespace App\Http\Requests\KanbanBoard\Comment;

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
            'content' => ['required_without:files'],
            'task_id' => ['required', 'exists:tasks,id'],
            'user_id' => ['required', 'exists:users,id'],
            'files' => ['nullable', 'array'],
            'files.*' => ['required'],
        ];
    }
}
