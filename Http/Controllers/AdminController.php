<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Coach;
use App\Player;
use App\Management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Validator;
//use Illuminate\Pagination\LengthAwarePaginator;
/*use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class AdminController extends Controller
{
//	public function getDashboard()
//	{
//		//return dashboard.blade.php
//		return view('dashboard');
//	}
	public function getAddNewUser()
	{
		return view('admin_view.addNewUser');
	}
	public function getEditPopUp()
	{
		return view('admin_view.editPopUp');
	}
	public function getEditUser()
	{
				$data = DB::table('users')->paginate();
		return view('admin_view.editUser')->with('data',$data);
	}
	public function getEditUserM()
	{
				$data = DB::table('users')->where('role', 'management')->paginate();
		return view('admin_view.editUser')->with('data',$data);
	}

	public function getEditUserP()
	{
				$data = DB::table('users')->where('role', 'player')->paginate();
		return view('admin_view.editUser')->with('data',$data);
	}

	public function getEditUserC()
	{
				$data = DB::table('users')->where('role', 'coach')->paginate();
		return view('admin_view.editUser')->with('data',$data);
	}

	public function getEditUserA()
	{
				$data = DB::table('users')->where('role', 'admin')->paginate();
		return view('admin_view.editUser')->with('data',$data);
	}


	public function postAddNewUser(Request $request)
	
	{
	$this->validate($request,[
			'email' =>'required|email' ,
			'name' => 'required|max:120|alpha' ,
			'password' => 'required|min:6' ,
			'user_name'=> 'required'
			

			]);
	

		$email = $request['email'];
		$name = $request['name'];
		$password = bcrypt($request['password']);
		$user_name = $request['user_name'];
		$role = $request['role'];
		//$role = $request[Input::get('role')];
		
		
		$user = new User();
		$user->user_name= $user_name;
		$user->name = $name;
		$user->email = $email;
		
		$user->password = $password;
		
		$user->role= $role;

	/*
		--
		defining one to one relationship and has a relationship
		Player belongs to user, user has players.
	*/

		$user->save();
		if($user->role === 'coach') { 	// save user_id in coach table
       		$coach = new Coach();
           $coach->user()->associate($user);
           $coach->save();  
        }
        if($user->role === 'player') {		//save user_id in player table
       		$player = new Player();
           $player->user()->associate($user);
           $player->save();  
        }

        if($user->role === 'management') {	//if user is a manager, save user_id in management table
       		$management = new Management();
           $management->user()->associate($user);
           $management->save();  
        }

		 \Session::flash('flash_message','successfully saved.');

		    $request->session()->flash('alert-success', 'User was successful added!');
    
		return redirect()->back();
		

	}

	public function edit($id)
	{
		$user = DB::table('users')->where('id',$id)->first();

		return view('admin_view.editPopUp')->with('user',$user);
	}

// Function which will updat the value of users when clicked on edit and update button
	public function update(Request $request)
	
	{
			$post = $request->all();
			$v = \Validator::make($request->all(),
				[
					'email' =>'unique:users|required|email',
					'name' => 'required|max:120|alpha',
					'user_name'=> 'unique:users|required',
					'role' => 'required'
				]);

			if($v->fails())
			{
				return redirect()->back()->withErrors($v->errors());
			}

			else
			
			{

				$data = array(
						'email' => $post['email'],
						'name' => $post['name'],
						'user_name' => $post['user_name'],
						'role' => $post['role']
						);

				$i= DB::table('users')->where('id', $post['id'])->update($data);
				
				if($i > 0)
				{
				  	  \Session::flash('alert-success', 'User was successful Updated!');
		    	
						return redirect()->route('editUser');
				}
				
			}	
		

		


	}	




	public function delete($id)
	{
		$i = DB::table('users')->where('id',$id)->delete();
		if($i > 0)
		{
		  	  \Session::flash('alert-success', 'User was successful Deleted!');
    	
				return redirect()->back();
		}
	}
	/*Below will show All players in the Edit User 
	*screen with all the players and there info. plus 
	*edit and delete  functionality.
	*/

	
		//Auth::login($user);
		//to return on a specific page. in this case, login
		//return redirect()->route('login');

	public function getChart()
	{
		$admin = DB::table('users')->where('role', 'admin')->get();
		$coach = DB::table('users')->where('role', 'coach')->get();
		$player = DB::table('users')->where('role', 'player')->get();
		$management = DB::table('users')->where('role', 'management')->get();
		return view('admin_view.stats', ['admin' => $admin,
																'coach' => $coach,
																'player' => $player,
																'management'=>$management
															]);
	}
}
	

