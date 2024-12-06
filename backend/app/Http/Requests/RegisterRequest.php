<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array // правила валидации
    {
        return [
            'name' => 'required|string|regex:/^[А-Яа-яЁёs.-]+$/u',
            'phone' => 'required|string|regex:/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages(): array // сообщения при неуспешной валидации
    {
        return [
            'name.required' => 'Заполните имя при регистрации',
            'name.regex' => 'Используйте символы кириллицы, пробелы, точки и тире',
            'phone.required' => 'Заполните номер телефона при регистрации',
            'phone.regex' => 'Номер не соответствует стандартному формату',
            'email.required' => 'Заполните почту при регистрации',
            'email.unique' => 'Данная почта уже зарегистрирована',
            'password.min' => 'Используйте минимум 8 символов для пароля',
            'password.required' => 'Заполните пароль при регистрации',
            'avatar.mimes' => 'Используйте формат для загрузки фотографии jpeg или png',
            'avatar.max' => 'Вы не можете загрузить фотографию превышающую 2 мб'
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 401)); //статус ошибки при неудачной валидации
    }
}
