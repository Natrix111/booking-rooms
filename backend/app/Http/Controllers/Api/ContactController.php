<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return Contact::all();
    }

    public function update(Request $request)
    {

        // Валидация входящих данных
        $request->validate([
            'address' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'social_links' => 'nullable|array',
        ]);

        // Получаем первый контакт (предполагается, что запись одна)
        $contact = Contact::first();

        // Обновляем только те поля, которые были переданы в запросе
        if ($request->has('address')) {
            $contact->address = $request->input('address');
        }
        if ($request->has('working_hours')) {
            $contact->working_hours = $request->input('working_hours');
        }
        if ($request->has('phone')) {
            $contact->phone = $request->input('phone');
        }
        if ($request->has('email')) {
            $contact->email = $request->input('email');
        }
        if ($request->has('social_links')) {
            $contact->social_links = $request->input('social_links');
        }

        // Сохраняем изменения
        $contact->save();

        return response()->json($contact);
    }
}
