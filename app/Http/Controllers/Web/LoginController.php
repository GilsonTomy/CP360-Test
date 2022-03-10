<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /* Login page */
    public function index()
    {
        $data = [];
        return view('web.login', $data);
    }

    /* User authentication  */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $remember_me  = (!empty($request->remember_me)) ? TRUE : FALSE;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember_me)) {
            $request->session()->regenerate();
            return redirect()->intended(route('web.dashboard'));
        }

        return back()->withInput($request->all())->with('errorLogin', 'Invalid user credentials.');
    }

    /* Destroy user session and logout*/
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'))->with('statusLogin', 'Logout successfull.');
    }
}
