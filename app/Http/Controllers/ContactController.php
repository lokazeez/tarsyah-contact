<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'phone_number' => 'required',
            'items' => 'required',
            'images.*' => 'mimes:jpg,png,jpeg|max:16384',
        ]);

        $contact = new Contact;

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->id_number = $request->id_number;
        $contact->phone_number = $request->phone_number;
        $contact->message = $request->message;
        $contact->items = implode(',', $request->items);
        $contact->save();

        if ($request->hasFile('images')) {
            $fileAdders = $contact->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->preservingOriginal()->toMediaCollection('images');
                });
        }

        if ($request->hasFile('attachments')) {
            $fileAdders = $contact->addMultipleMediaFromRequest(['attachments'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('attachments');
                });
        }


        $contact->save();

        return redirect()->route('thanks');
    }
}
