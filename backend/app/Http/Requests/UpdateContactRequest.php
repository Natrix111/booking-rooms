<?php

   namespace App\Http\Requests;
   
   use Illuminate\Http\Exceptions\HttpResponseException;
   use Illuminate\Support\Facades\Validator;
   use Illuminate\Foundation\Http\FormRequest;

   class UpdateContactRequest extends FormRequest
   {
       public function authorize()
       {
           return true; 
       }

       public function rules(): array      
       {
           return [
               'address' => 'nullable|string|max:255',
               'working_hours' => 'nullable|string|max:255',
               'phone' => 'nullable|string|max:255',
               'email' => 'nullable|email|max:255',
               'social_links' => 'nullable|array',
           ];
       }
       public function messages(): array 
       {
           return [
               'email.email' => 'Неверный формат почты',
               'social_links.array' => ' Список ссылок должен быть типа array',

           ];
       }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 401));
    }
   }