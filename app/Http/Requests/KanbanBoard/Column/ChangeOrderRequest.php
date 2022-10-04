<?php

namespace App\Http\Requests\KanbanBoard\Column;

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
            'columns' => ['required', 'array'],
            'columns.*.id' => ['required', 'exists:columns,id'],
            'columns.*.order' => ['required'],
        ];
    }
}
