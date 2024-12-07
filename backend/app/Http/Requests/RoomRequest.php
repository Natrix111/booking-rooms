<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;


class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }    public function rules(): array
    {
        return [
            'name' => $this->isMethod('post') ? 'required|string' : 'nullable|string',
            'width' => $this->isMethod('post') ? 'required|string' : 'nullable|integer|min:1',
            'height' => $this->isMethod('post') ? 'required|string' : 'nullable|integer|min:1',
            'length' => $this->isMethod('post') ? 'required|string' : 'nullable|integer|min:1',
            'amenities' => 'nullable|array',
            'amenities.*' => 'nullable|integer|exists:amenities,id', 
            'price' => $this->isMethod('post') ? 'required|string' : 'nullable|numeric',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured' => 'boolean',
        ];
    }    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'width.required' => 'Ширина обязательна для заполнения.',
            'height.required' => 'Высота обязательна для заполнения.',
            'length.required' => 'Длина обязательна для заполнения.',
            'amenities.array' => 'Удобства должны быть массивом.',
            'amenities.*.exists' => 'Нет удобства с таким id',
            'price.required' => 'Цена обязательна для заполнения.',
            'photos.array' => 'Фотографии должны быть массивом.',
            'photos.max' => 'Максимально можно загрузить 5 фотографий.',
            'photos.*.image' => 'Каждый элемент должен быть изображением.',
            'photos.*.mimes' => 'Поддерживаются только изображения формата: jpeg, png, jpg, gif.',
            'photos.*.max' => 'Изображение не должно превышать 2MB.',
            'amenities.*.integer' => 'Должны быть указаны id удобств',
        ];
    }
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 401));
    }
}