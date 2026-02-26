<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $this->category->id,
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Назва" є обов\'язковим',
            'name.unique' => 'Категорія з такою назвою уже існує',
            'name.max' => 'Назва не повинна перевищувати 255 символів',
        ];
    }
}
