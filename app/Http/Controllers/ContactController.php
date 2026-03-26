<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends AppController
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'inquiry' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: send email or save to database

        return back()->with('success', 'Your message has been sent. We will get back to you shortly.');
    }
}
