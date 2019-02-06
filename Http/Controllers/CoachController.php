<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\Coach;
use App\Player;
use App\Post;
use App\Management;
use App\Admin;
use App\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Khill\Lavacharts\Lavacharts;

class CoachController extends Controller
{
		//use Input;

		public function getCoach()
	{
		$posts = Post::with('coach')->with('player')->orderBy('created_at', 'desc')->get();
   foreach($posts as $p)
   {
   	$exc_name= $p->exercise->name;
   $per = ($p->exc_data / $p->exercise->threshold) * 100 ; 
   }

		return view('home.coach', ['posts' => $posts,
																'per' => $per,
																'exc_name' => $exc_name,
															]);
	}

		public function update()
		{
			 // to redirect to about page, use this   
			 // return view('about.contact');
			return redirect()->back();
		}

		public function store()
		{
			return \Redirect::route('contact')
			->with('message', 'Thanks for contacting us!');



		}



					//------ All get Views for routers-------------//

			public function getAllPlayers()
			{

						$data = Player::with('user')->paginate(15);
						return view('coach.Players')->with('data',$data);
				
			}


			public function getEditExercise($player_id)
			{
				$player  = Player::with('user')->where('id',$player_id)->first();
				
				
				return view('coach.playerAddExercise')->with('player',$player);
					
			}


			public function comparePlayer($player_id)
			{
				$player  = Player::with('user')->where('id',$player_id)->first();
				
				//$playerList = DB::table('players')->orderBy('id')->lists( 'id');
				$playerList = DB::table('users')->where('role', 'player')->orderBy('name')->lists('name' ,'id');
				
				
				
				return view('coach.comparePlayer',[ 'player'=>$player,
													'playerList'=>$playerList
													]);
					
			}
			public function compareResult(Request $request)
			{
				
						$playerOne_id = $request['playerOne_id'];
						$p2_id = $request['playerList'];
						$playerTwo = Player::with('user')->where('user_id' , $p2_id)->first();
						$playerTwo_id = $playerTwo->id;

						$running = DB::table('exercises')->where('name', 'running')->first();

						$running_id = $running->id; 

						$p1_running = DB::table('posts')->where('exercise_id', $running_id)
														->where('player_id', $playerOne_id)
														->get();
						$p2_running = DB::table('posts')->where('exercise_id', $running_id)
														->where('player_id', $playerTwo_id)
														->get();


						$walking = DB::table('exercises')->where('name', 'walking')->first();

						$walking_id = $walking->id; 

						$p1_walking = DB::table('posts')->where('exercise_id', $walking_id)
														->where('player_id', $playerOne_id)
														->get();
						$p2_walking = DB::table('posts')->where('exercise_id', $walking_id)
														->where('player_id', $playerTwo_id)
														->get();
														

				

						return view('coach.compareResult' , [
															 'playerOne_id'=>$playerOne_id,
															 'playerTwo_id'=>$playerTwo_id,
															 'running_id'=>$running_id,
															 'p1_running'=>$p1_running,
															 'p2_running'=>$p2_running,
															 'walking_id'=>$walking_id,
															 'p1_walking'=>$p1_walking,
															 'p2_walking'=>$p2_walking

															]);
				
				
			}

			


			public function getAddExercise($player_id)
			{
				   // See note below for Laravel


				

				$LoggedInUser = Auth::user()->id;
				$exercise = DB::table('exercises')->orderBy('name')->lists('name', 'id');

				
				$player = Player::with('user')->where('id',$player_id)->first();
				
					 //to call a name, do $player->user->name
				$coach = Coach::with('user')->where('user_id', $LoggedInUser)->first();
						return view('coach.addExercise', [ 
																						'player' =>$player,
																					 'exercise' =>$exercise,
																					 'LoggedInUser' =>$LoggedInUser,
																					 'coach' =>$coach,
																					 
																					 ]);

					
			}


			public function postExercise(Request $request)
	
	{
			$threshold = DB::table('exercises')->where('id', $request->input('exercise'))->first();

			 	$this->validate($request,[
			'exerciseData' =>"required|integer|between:0,$threshold->threshold" ,
			'content' => 'max:255' ,
		
			

			]);
	

		$exerciseData = $request['exerciseData'];
		$content = $request['content'];
		$player_id = $request['player_id'];
		$coach_id = $request['coach_id'];
		$exercise_id = Input::get('exercise');;

		//$role = $request[Input::get('role')];
		
		$performance = $request->input('exerciseData' ) / $threshold->threshold * 100;

 
		
		$post = new Post();
		$post->exc_data= $exerciseData;
		$post->player_id = $player_id;
		$post->coach_id = $coach_id;
		$post->content = $content;
		$post->exercise_id = $exercise_id;
		$post->performance = $performance;
		
		$post->save();

		$request->session()->flash('alert-success', 'exercise data  successful added!');
		//return redirect()->route("photo.index");
		return redirect()->back();
		

	}



}
