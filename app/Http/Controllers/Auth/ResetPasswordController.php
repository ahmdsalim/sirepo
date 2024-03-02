<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->save();

        event(new PasswordReset($user));

        if ($user->is_active) {
            $this->guard()->login($user);
            $this->authenticated($user);
        }
    }

    public function authenticated($user)
    {
        switch ($user->role) {
            case 'super':
                $this->redirectTo = 'home';
                break;
            case 'admin':
                $this->redirectTo = 'home';
                break;
            case 'user':
                $this->redirectTo = '/';
                break;
        }
    }
}
