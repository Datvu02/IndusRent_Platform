<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function showContactForm(): View
    {
        return view('frontend.pages.lien-he');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'txtcValue01' => 'required|string|max:255',
            'txtcValue02' => 'nullable|string|max:255',
            'txtcValue03' => 'nullable|string|max:255',
            'txtcValue04' => 'nullable|string|max:500',
            'txtcValue05' => 'nullable|string|max:50',
            'txtcValue06' => 'nullable|email',
            'txtcValue08' => 'nullable|string|max:5000',
        ], [
            'txtcValue01.required' => 'Vui lòng nhập họ và tên.',
        ]);

        Inquiry::create([
            'type' => 'contact',
            'name' => $validated['txtcValue01'],
            'company' => $validated['txtcValue02'] ?? null,
            'nationality' => $validated['txtcValue03'] ?? null,
            'address' => $validated['txtcValue04'] ?? null,
            'phone' => $validated['txtcValue05'] ?? null,
            'email' => $validated['txtcValue06'] ?? null,
            'message' => $validated['txtcValue08'] ?? '',
        ]);

        return redirect()->route('lien-he')->with('message', 'Cảm ơn bạn. Chúng tôi sẽ liên hệ sớm.');
    }

    public function showRequestForm(): View
    {
        return view('frontend.pages.noi-dung-yeu-cau');
    }

    public function storeRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'txtcValue01' => 'required|string|max:255',
            'txtcValue02' => 'nullable|string|max:255',
            'txtcValue05' => 'required|string|max:50',
            'txtcValue06' => 'required|email',
            'txtcValue08' => 'required|string|max:5000',
        ], [
            'txtcValue01.required' => 'Vui lòng nhập họ và tên.',
            'txtcValue05.required' => 'Vui lòng nhập điện thoại.',
            'txtcValue06.required' => 'Vui lòng nhập email.',
            'txtcValue08.required' => 'Vui lòng nhập nội dung yêu cầu.',
        ]);

        Inquiry::create([
            'type' => 'request',
            'name' => $validated['txtcValue01'],
            'company' => $validated['txtcValue02'] ?? null,
            'phone' => $validated['txtcValue05'],
            'email' => $validated['txtcValue06'],
            'message' => $validated['txtcValue08'],
        ]);

        return redirect()->back()->with('message', 'Đã gửi yêu cầu. Chúng tôi sẽ xử lý sớm.');
    }
}
