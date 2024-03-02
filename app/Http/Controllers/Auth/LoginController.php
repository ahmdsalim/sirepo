<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user)
    {
        $routeName = 'landing';
        switch ($user->role) {
            case 'super':
                $routeName = 'home';
                break;
            case 'admin':
                $routeName = 'home';
                break;
        }
        return to_route($routeName);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        // Cek apakah pengguna sudah diaktifkan
        $credentials = $this->credentials($request);
        if (!$this->isUserExist($credentials)) {
            return $this->sendFailedLoginResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request, 'Akun Anda telah dinonaktifkan. Silahkan menghubungi Admin untuk mengaktifkan akun.');
    }

    protected function isUserExist(array $credentials)
    {
        // Ambil pengguna berdasarkan kredensial yang diberikan
        $user = User::where('username', $credentials['username'])->first();

        // Periksa apakah pengguna ditemukan dan passwordnya benar
        return $user && Hash::check($credentials['password'], $user->password);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->boolean('remember')
        );
    }

    protected function credentials(Request $request)
    {
        $credentials = array_merge($request->only($this->username(), 'password'), ['is_active' => true]);
        return $credentials;
    }

    protected function sendFailedLoginResponse(Request $request, $message = '')
    {
        $message = $message ?: trans('auth.failed');

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }
}
