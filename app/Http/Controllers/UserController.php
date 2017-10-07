<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Permission;
use App\Post;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		return view('user.index');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function notifications()
	{
		$notifications = Notification::where('user_id',Auth::id())->paginate(5);
		return view('user.notifications', compact('notifications'));
    }

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function readNotification($id)
	{
		$notification = Notification::find($id);

		if($notification->read == 1) $notification->read = 0;
		else $notification->read = 1;

		$notification->save();

		return back();
    }

	/**
	 * @param $id
	 */
	public function deleteNotification($id)
	{
		Notification::find($id)->delete();

		echo json_encode(['status'=>1,'message'=>'آیتم مورد نظر حذف شد!']);
    }

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function profile()
	{
		$user = Auth::user();
		return view('user.edit', compact('user'));
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateProfile(Request $request)
	{
		$user_id = Auth::id();
		$user = User::find($user_id);

		$input = $request->only(['name','email','image']);

		if($request->image)
		{
			if(!empty($user->image))
			{
				if(file_exists(public_path('images/user/').$user->image))
					unlink(public_path('images/user/').$user->image);
			}

			$input['image'] = time().'.'.$request->image->getClientOriginalExtension();
			$image = Image::make($request->image);
			$image->resize(100,100);

			$image->save(public_path('images/user/').$input['image']);
		}

		$user->update($input);

		session()->flash('success-message','اطلاعات شما با موفقیت ثبت شد!');

		return back();
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function newUser()
	{
//		$permissions = Permission::all();
		$roles = Role::all();
		return view('user.new', compact('roles'));
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function createUser(Request $request)
	{
		$this->validate($request, [
			'name'=>'required',
			'email'=>'required|email',
			'password'=>'required|min:5',
		]);

		$input = $request->only(['name','email','password','parent']);

		if(!empty($input['password']))
		{
			$input['password'] = bcrypt($input['password']);
		}

		$input['parent'] = Auth::id();
		$user = User::create($input);

		if(!empty($request->roles)) $user->syncRoles($request->roles);

		session()->flash('success-message', 'کاربر با موفقیت ثبت شد!');

		return back();
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function listUserPostToConfirm()
	{
		$users = User::findChild(Auth::id());
		$posts = Post::whereIn('user_id', $users)->paginate(5);
		return view('user.confirm-user-post', compact('posts'));
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function userPostConfirm($id)
	{
		$post = Post::find($id);
		if($post->confirm_admin_post == 1) $post->confirm_admin_post = 0;
		else $post->confirm_admin_post = 1;

		$post->save();

		return back();
	}

	/**
	 * @param $id
	 *
	 * @return download file
	 */
	public function backup($id)
	{
		$user = User::whereId($id)->select(['name','email','image'])->first();
		$make_data = [
			'name'=>$user->name,
			'email'=>$user->email,
			'image'=>$user->image
		];
		$json_data = json_encode($make_data);

		$file_name = 'file'.time().'.json';

		Storage::put($file_name, $json_data, 'public');
		$file = Storage::get($file_name);

		// Remove file
		Storage::delete($file_name);

		return (new Response($file, 200))
			->withHeaders(['Content-Type'=> 'application/json','Content-disposition' => 'attachment; filename=backup-user-'.$id.'.json']);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function restore(Request $request)
	{
		if($request->file_restore and !empty($request->file_restore))
		{
			$user_id = $request->user_id;

			$file = $request->file('file_restore');
			$data = File::get($file);

			$arr_data = json_decode($data, true);

			User::find($user_id)->update($arr_data);

			session()->flash('success-message', 'اطلاعات شما با موفقیت آپدیت شد!');

			return back();
		}
		session()->flash('warning-message', 'هیچ فایلی انتخاب نشده است!');
		return back();
	}
}
