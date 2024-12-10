<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateContactRequest;
class ContactController extends Controller
{
    public function index()
    {
        return Contact::all();
    }

    public function update(UpdateContactRequest $request)
    {
        $contact = Contact::first();

        $contact->fill($request->only([
            'address',
            'working_hours',
            'phone',
            'email',
            'social_links',
        ]));

        $contact->save();

        return response()->json($contact);
    }
}
