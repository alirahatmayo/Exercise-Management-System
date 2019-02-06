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
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Khill\Lavacharts\Lavacharts;

class CommentController extends Controller
{
		//use Input;

		public function postComment(Request $request)

		{
			

			 	$this->validate($request,[
			'comment' => 'required|max:255' ,
		
			

			]);
	

		$comnt = $request['comment'];
		$post_id = $request['p_id'];
		$user_id = Auth::User()->id;

 
		
		$comment = new Comment();
		$comment->cmnt_cntnt= $comnt;
		$comment->user_id = $user_id;
		$comment->post_id = $post_id;
		
		
		$comment->save();

		$request->session()->flash('alert-success', 'Comment Posted!');
		return redirect()->back();
		}
}