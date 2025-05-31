<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected $maxAttempts = 5;
    protected $decayMinutes = 15;

    protected function authenticated(Request $request, $user)
    {
        Activity::create([
            'log_name' => 'auth',
            'description' => 'User logged in',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'causer_type' => User::class,
            'causer_id' => $user->id,
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Always remember the user (persistent login)
        $remember = true;
        if (Auth::attempt($this->credentials($request), $remember)) {
            return redirect()->intended($this->redirectPath());
        }

        return $this->sendFailedLoginResponse($request);
    }
}