<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class BookingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'pets' => 'required|array|min:1|max:4',
            'pets.*' => 'required|string|regex:/^[а-яА-ЯёЁa-zA-Z0-9\s\-]+$/',
            'check_in' => 'required|date_format:Y-m-d|after_or_equal:today',
            'check_out' => 'required|date_format:Y-m-d|after:check_in',
            'room_id' => 'required|exists:rooms,id',
        ];
    }

    public function messages()
    {
        return [
            'pets.required' => 'Необходимо указать хотя бы одного питомца.',
            'pets.array' => 'Питомцы должны быть в виде массива.',
            'pets.*.required' => 'Имя питомца обязательно для заполнения.',
            'pets.*.regex' => 'Имя питомца может содержать только буквы, пробелы и тире.',
            'check_in.required' => 'Дата заезда обязательна.',
            'check_in.date_format' => 'Неверный формат даты заезда.',
            'check_in.after_or_equal' => 'Дата заезда должна быть не раньше текущей даты.',
            'check_out.required' => 'Дата выезда обязательна.',
            'check_out.date_format' => 'Неверный формат даты выезда.',
            'check_out.after' => 'Дата выезда должна быть позже даты заезда.',
            'room_id.required' => 'Номер комнаты обязательен.',
            'room_id.exists' => 'Выбранный номер комнаты не существует.',
        ];
    }
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 401));
    }
}