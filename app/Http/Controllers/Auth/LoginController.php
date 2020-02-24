<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/';

     /**
     * OAuth認証先にリダイレクト
     *
     */
    public function redirectToProvider($provider)
    {
        return Socialite::with($provider)->redirect();
    }

     /**
     * OAuth認証の結果受け取り
     *
     */
    public function handleProviderCallback($provider)
    {

        try {
            $providerUser = \Socialite::with($provider)->user();
        } catch(\Exception $e) {
            return redirect('/login')->with('message', '予期せぬエラーが発生しました');
        }

        if ($email = $providerUser->getEmail()) {
            Auth::login(User::firstOrCreate([
                'email' => $email
            ], [
                'name' => $providerUser->getName(),
                'provider_user_id' => $providerUser->getId()
            ]));

            return redirect($this->redirectTo)->with('message', 'ログインしました');
        } else {
            return redirect('/login')->with('message', 'メールアドレスが取得できませんでした');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ログイン時の認証エラーをオーバライド
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('認証に失敗しました。')],
        ]);
    }
}
