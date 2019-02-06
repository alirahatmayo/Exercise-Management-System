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

class PlayerController extends Controller
{
		//use Input;
		public function getPlayer()
	{
		$user_id= Auth::user()->id;
		$player= DB::table('players')->where('user_id', $user_id)->first();
		$player_id= $player->id;



		$player_post = Post::with('player')->where('player_id', $player_id)->get();
		$last_exercise = Post::with('player')->with('exercise')->where('player_id', $player_id)->orderBy('created_at', 'desc')->first();

		return view('player_view.player',[ 'player_post'=>$player_post,
											'last_exercise'=>$last_exercise
											
													]);
	}

}