<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends AppController
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'inquiry'              => 'nullable|string|max:100',
            'message'              => 'required|string|max:5000',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Please complete the CAPTCHA.',
        ]);

        $recaptcha = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (! $recaptcha->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'CAPTCHA verification failed. Please try again.'])->withInput();
        }

        Mail::to('info@dflzambia.com')->send(new ContactMail(
            senderName:  $validated['name'],
            senderEmail: $validated['email'],
            inquiry:     $validated['inquiry'] ?? '',
            messageBody: $validated['message'],
        ));

        return back()->with('success', 'Your message has been sent. We will get back to you shortly.');
    }
}
