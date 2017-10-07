<?php

namespace App\Http\Controllers\Admin;

use App\Notification;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
	public function managePosts()
	{
		$posts = Post::getConfirmedPosts()->enabledPost()->paginate(5);
		return view('admin.post.manage', compact('posts'));
    }

    public function confirmPost($id)
	{
		$post = Post::find($id);
		$user_id = $post->user_id;
		$message = '';
		if($post->enabled == 1)
		{
			$post->enabled = 0;
			$message = 'مدیریت پست ('.$post->id.') شما را غیر فعال کرد. برای اطلاعات بیشتر تماس بگیرید.';
		}
		else
		{
			$post->enabled = 1;
			$message = 'مدیریت پست ('.$post->id.') شما را فعال کرد.';
		}
		$post->save();

		$notif_params = [
			'user_id'=>$user_id,
			'message'=>$message
		];

		Notification::create($notif_params);

		return back();
    }
}
