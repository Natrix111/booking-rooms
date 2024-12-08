<?php

   namespace App\Http\Requests;

   use Illuminate\Http\Exceptions\HttpResponseException;
   use Illuminate\Support\Facades\Validator;
   use Illuminate\Foundation\Http\FormRequest;
   class UpdateInformationRequest extends FormRequest
   {
       public function authorize()
       {
           return true; 
       }

       public function rules(): array
       {
           return [
               'title' => 'nullable|string|max:30',
               'slogan' => 'nullable|string',
               'city' => 'nullable|string|max:50',
           ];
       }
       public function messages(): array 
       {
        return [
            'title.string' => 'Поле "название" должно быть строкой.',
            'title.max' => 'Поле "название" не должно превышать 30 символов.',
            'slogan.string' => 'Поле "слоган" должно быть строкой.',
            'city.string' => 'Поле "город" должно быть строкой.',
            'city.max' => 'Поле "город" не должно превышать 50 символов.',
        ];
       }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 401));
    }
   }