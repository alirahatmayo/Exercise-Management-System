<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function getRegister()

    {

        return redirect('/register');

    }
 

    public function postRegister()

    {

        return redirect('/register');

    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'user_name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ]);
    }
    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'user_name' => $data['user_name'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin(Request $request)
    {
        //Helpper functionfor for authacation of login attempts if they passes go to dashboard,  else go back

        if (Auth::attempt(['email' => $request['email'], 'password' =>$request['password']])){
            
            return redirect()->route('admin');
        }               
        return redirect()->back();
    }
//        below is the function to redirect using values in role column
    // we are over riding it to pass condition to move to the page defined in roles in user table

      protected function authenticated($request, $user)
   {
       if($user->role === 'admin') {
           return redirect()->intended('/admin');  
        }

        elseif($user->role === 'coach') {
           return redirect()->intended('/coach');
            }

        elseif($user->role === 'management') {
           return redirect()->intended('/management');
            }

        elseif($user->role === 'player') {
           return redirect()->intended('/player');
            }

       return redirect()->intended('/');
    }



/*            protected function authenticated( $user)
    {

        if($user->role === 'admin') {
            return redirect('/admin');
        }

        return redirect('login');
    } */
}

