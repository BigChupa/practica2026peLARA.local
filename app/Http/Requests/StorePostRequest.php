<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
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
