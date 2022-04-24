<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use League\OAuth2\Server\AuthorizationServer;
use Nyholm\Psr7\Response as Psr7Response;

class LoginController extends Controller
{
    use ConvertsPsrResponses, RetrievesAuthRequestFromSession;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }


    function oauthRedirect() {
        return Socialite::driver(request()->get('type'))->redirect();
    }
    function oauthCallback(Request $request) {
        if(!in_array(request()->get("type"), ["github"])) {
            abort(404);
        }
        $githubUser = Socialite::driver(request()->get("type"))->user();
        $user = User::where("email", $githubUser->email)->first();
        if($user) {
            $user->update([
                "github_id" => $githubUser->id
            ]);
        } else {
            return redirect("/register");
        }
        // $user = User::updateOrCreate([
        //     'github.id' => $githubUser->id,
        // ], [
        //     'name' => $githubUser->name,
        //     'email' => $githubUser->email,
        //     // 'github_token' => $githubUser->token,
        //     // 'github_refresh_token' => $githubUser->refreshToken,
        // ]);
     
        Auth::login($user);

        $this->assertValidAuthToken($request);

        $authRequest = $this->getAuthRequestFromSession($request);

        return $this->convertResponse(
            $this->server->completeAuthorizationRequest($authRequest, new Psr7Response)
        );
    }
}
