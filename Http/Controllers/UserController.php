<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Coach;
use App\Management;
use App\Admin;
/*use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class UserController extends Controller
{
//	public function getDashboard()
//	{
//		//return dashboard.blade.php
//		return view('dashboard');
//	}
	public function getAdmin()
	{
		return view('home.admin');
	}

	public function getCoach()
	{
		return view('home.coach');
	}

		public function getPlayer()
	{
		return view('home.player');
	}

		public function getManagement()
	{
		return view('home.management');
	}
//	
	public function postRegister(Request $request)
	{
		$email = $request['email'];
		$first_name = $request['first_name'];
		$password = bcrypt($request['password']);
		$user_name = $request['user_name'];
		//$role = $request['role'];
		$role = $requrst[Input::get('role')];
		
	

		$user = new User();
		$user->user_name= $user_name;
		$user->first_name = $first_name;
		$user->email = $email;
		
		$user->password = $password;
		
		$user->role= $role;

		$user->save();
		
       if($user->role === 'coach') {
       		$coach = new Coach();
           //$coach->user()->save($coach);  
        }

		 \Session::flash('flash_message','successfully saved.');
		
	}

		/*public function postAddNewUser(Request $request)
	{
		$email = $request['email'];
		$first_name = $request['first_name'];
		$password = bcrypt($request['password']);
		$user_name = $request['user_name'];
		$role = $request['role'];
		//$role = $request[Input::get('role')];
		
		
		$user = new User();
		$user->user_name= $user_name;
		$user->first_name = $first_name;
		$user->email = $email;
		
		$user->password = $password;
		
		$user->role= $role;

		$user->save();
		return redirect()->back();
		//Auth::login($user);
		//to return on a specific page. in this case, login
		//return redirect()->route('login');
	}
*/


	public function postLogin(Request $request)
	{
		//Helpper functionfor for authacation of login attempts if they passes go to dashboard,  else go back

		if (Auth::attempt(['email' => $request['email'], 'password' =>$request['password']])){
			
			return redirect()->route('admin');
		}				
		return redirect()->back();
	}
}

