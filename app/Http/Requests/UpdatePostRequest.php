<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле "Заголовок" є обов\'язковим',
            'title.max' => 'Заголовок не повинен перевищувати 255 символів',
            'content.required' => 'Поле "Вміст" є обов\'язковим',
            'category_id.required' => 'Поле "Категорія" є обов\'язковим',
            'category_id.exists' => 'Вибрана категорія не існує',
        ];
    }
}
