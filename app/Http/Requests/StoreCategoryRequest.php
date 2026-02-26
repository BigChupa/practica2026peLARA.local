<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories',
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
