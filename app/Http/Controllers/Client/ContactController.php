<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact; 
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // Hiển thị form liên hệ
    public function showForm()
    {
        return view('client.pages.contact');
    }

    
    public function submitForm(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('client.contact.form')
                        ->withErrors($validator)
                        ->withInput();
        }

      
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

      

        return redirect()->route('client.contact.form')->with('success', 'Message sent successfully!');
    }
}