<?php

namespace App\Http\Requests\KanbanBoard\Task;

use Illuminate\Foundation\Http\FormRequest;

class AssignCollaboratorsRequest extends FormRequest
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
            'collaborators' => ['nullable', 'array'],
            'collaborators.*' => ['required', 'exists:users,id'],
        ];
    }
}
