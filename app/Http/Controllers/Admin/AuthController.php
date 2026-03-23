<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard("admin")->check()) {
            return redirect()->route("admin.dashboard");
        }
        return view("admin.auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required|string|min:6",
        ]);

        if (Auth::guard("admin")->attempt($credentials, $request->filled("remember"))) {
            $request->session()->regenerate();
            return redirect()->intended(route("admin.dashboard"))
                ->with("message", "Đăng nhập thành công!");
        }

        return back()->withErrors([
            "email" => "Thông tin đăng nhập không chính xác.",
        ])->onlyInput("email");
    }

    public function logout(Request $request)
    {
        Auth::guard("admin")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("admin.login")
            ->with("message", "Đã đăng xuất thành công!");
    }
}
