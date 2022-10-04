<?php

namespace App\Http\Requests\KanbanBoard\Column;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => ['required', Rule::unique('columns', 'name')->where('table_id', $this->table_id)->ignoreModel($this->column)],
            'order' => ['sometimes', 'numeric'],
            'table_id' => ['required', 'exists:tables,id'],
        ];
    }
}
