<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail; // Sử dụng để gửi email (nếu cần)
use App\Models\Contact; // Nếu lưu vào cơ sở dữ liệu
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // Hiển thị form liên hệ
    public function showForm()
    {
        return view('client.pages.contact');
    }

    // Xử lý khi người dùng submit form
    public function submitForm(Request $request)
    {
        // Validation dữ liệu
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

        // Lưu vào cơ sở dữ liệu hoặc gửi email (tùy nhu cầu)
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // Gửi email (nếu cần)
        // Mail::to('admin@example.com')->send(new ContactMail($request->all()));

        return redirect()->route('client.contact.form')->with('success', 'Message sent successfully!');
    }
}