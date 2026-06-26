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
        $captcha = $this->generateCaptcha();
        session(['captcha_code' => $captcha]);
        
        return view('frontend.pages.lien-he');
    }
    
    private function generateCaptcha(): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $captcha;
    }
    
    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();
        session(['captcha_code' => $captcha]);
        
        return response()->json(['captcha' => $captcha]);
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
            'captcha' => 'required|string',
        ], [
            'txtcValue01.required' => __('validation.name_required'),
            'captcha.required' => __('validation.captcha_required'),
        ]);
        
        $sessionCaptcha = session('captcha_code');
        if (!$sessionCaptcha || strtoupper($validated['captcha']) !== strtoupper($sessionCaptcha)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['captcha' => __('validation.captcha_invalid')]);
        }

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

        return redirect()->route('lien-he')->with('message', __('validation.contact_success'));
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
            'txtcValue01.required' => __('validation.name_required'),
            'txtcValue05.required' => __('validation.phone_required'),
            'txtcValue06.required' => __('validation.email_required'),
            'txtcValue08.required' => __('validation.content_required'),
        ]);

        Inquiry::create([
            'type' => 'request',
            'name' => $validated['txtcValue01'],
            'company' => $validated['txtcValue02'] ?? null,
            'phone' => $validated['txtcValue05'],
            'email' => $validated['txtcValue06'],
            'message' => $validated['txtcValue08'],
        ]);

        return redirect()->back()->with('message', __('validation.request_success'));
    }
}
