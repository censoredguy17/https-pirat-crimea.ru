<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Пароль можно вынести в .env для безопасности
        $secretPassword = config('app.admin_password', 'BlackPearl2026');

        if ($request->password === $secretPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['password' => 'Неверная черная метка (пароль)!']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
