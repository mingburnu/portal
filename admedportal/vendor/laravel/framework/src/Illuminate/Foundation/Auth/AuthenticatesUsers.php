<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
//use Symfony\Component\HttpFoundation\ParameterBag;
use DB;

trait AuthenticatesUsers
{
    use RedirectsUsers;

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function postLogin(Request $request)
    {

//   +request: ParameterBag {#40 ▼
//    #parameters: array:3 [▼
//      "email" => "koha@sydt.com.tw"
//      "password" => "123456"
//      "_token" => "kHVlmrwfV16yNu1merAcZSkYtGOuf7pRJCFQgLK3"
//    ]
//  }
//

//        $data = $request;

//        ParameterBag $data;

//        $data = new ParameterBag(json_decode($request->request));

//        $data = $request->request;

//         $data = new ParameterBag();

//         $data = $request->request;

//        Log::info('log data -------' . dump($request));

//        Log::info('user name  ' . dump($this->loginUsername()));


//        $data = Auth::user();            

//        Log::info("data ................ " . dump($data));

//        exit();

        $request->request->add(['account'=>\Input::get('email')]);
        $this->validate($request, [
//            $this->loginUsername() => 'required',
            'account' => 'required',
            'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

//        Log::info('credential ------------------------ ' . dump($request));
//        exit();
    

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

//        Log::info("data ----------------------- " . dump($credentials));
//        exit();

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);


    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {


            //$data = Auth::user();
            
            //Log::info('data ...................... ' . dump($data));

            //exit();

            return $this->authenticated($request, Auth::user());
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {

        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {

       
//        Log::info('data ----------------------' . dump(Auth::user()));
//        exit();

        $data = Auth::user();

        DB::table('backend_login_stat')->insert(
            [
                'account_userid'            =>  $data['attributes']['email'],
                'logout'                    =>  1
            ]
        );

        Auth::logout();

//        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : 'auth/login');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {

//        Log:info('data -------------- ' . dump(property_exists($this, 'email')));
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }
}
