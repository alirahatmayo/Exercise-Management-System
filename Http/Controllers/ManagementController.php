<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use App\Coach;
use App\Player;
use App\Management;
use App\Post;
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
class ManagementController extends Controller
{
//	public function getDashboard()
//	{
//		//return dashboard.blade.php
//		return view('dashboard');
//	}
	public function dashboard()
	{
		$posts = Post::with('coach')->with('player')->orderBy('created_at', 'desc')->get();
   			foreach($posts as $p)
   {
   	$exc_name= $p->exercise->name;
   $per = ($p->exc_data / $p->exercise->threshold) * 100 ; 
   }

		return view('management.dashboard', ['posts' => $posts,
																'per' => $per,
																'exc_name' => $exc_name,
															]);
		
	}

}