<?php

namespace App\Http\Controllers;

use App\custom_functions;
use App\Post;
use Elibyy\TCPDF\TCPDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->except('index');
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $posts = Post::whereEnabled(1)->whereConfirmAdminPost(1)->paginate(6);
        return view('post.index', compact('posts'));
    }

	/**
	 * Showing posts per users
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function manage()
	{
		$posts = Post::where('user_id',Auth::id())->orderBy('id', 'desc')->paginate(5);
		return view('post.manage', compact('posts'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	if(!Auth::user()->hasRole('post-author|post-admin|superadministrator')) abort(403);
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        	'title'=>'required|max:150',
        	'content'=>'required',
        ]);

		$input = $request->only(['title','content','image','confirm_admin_post']);

		if($request->image)
		{
			$image_name = 'post-image-'.rand(1,1000);
			$ext = $request->image->getClientOriginalExtension();

			$input['image'] = $image_name.'.'.$request->image->getClientOriginalExtension();
			custom_functions::resizeImages($request, 'images/post/', $image_name);
		}

	    $input['user_id'] = Auth::id();

		if(Auth::user()->parent == 0) $input['confirm_admin_post'] = 1;

		Post::create($input);

		session()->flash('success-message','اطلاعات با موفقیت ثبت شد!');

		return back();
    }

	/**
	 * Display the specified resource.
	 *
	 * @param Post $post
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $post = Post::find($id);
	    if(!Auth::user()->hasRole('post-editor|post-admin|superadministrator')) abort(403, 'شما اجازه دسترسی به این صفحه را ندارید!');
	    elseif (Auth::id() != $post->user_id) abort(403, 'شما اجازه دسترسی به این صفحه را ندارید!');

	    return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    $this->validate($request, [
		    'title'=>'required|max:150',
		    'content'=>'required',
	    ]);

	    $post = Post::find($id);

	    $input = $request->only(['title','content','image','confirm_admin_post','enabled']);

	    if($request->image)
	    {
	    	if(!empty($post->image))
		    {
		    	if(file_exists(public_path('images/post/').$post->image))
		    	    unlink(public_path('images/post/').$post->image);
		    }

		    $image_name = 'post-image-'.rand(1,1000);

		    $input['image'] = $image_name.'.'.$request->image->getClientOriginalExtension();
		    custom_functions::resizeImages($request, 'images/post/', $image_name);
	    }

	    $input['enabled'] = 0;
	    $input['confirm_admin_post'] = 0;

	    $post->update($input);

	    session()->flash('success-message','اطلاعات با موفقیت آپدیت شد!');

	    return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    if(!Auth::user()->hasRole('post-admin|superadministrator')) abort(403);
        Post::find($id)->delete();

        echo json_encode(['status'=>1,'message'=>'آیتم مورد نظر حذف شد!']);
    }

	/**
	 * Remove all posts.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param $ids
	 *
	 * @internal param int $id
	 */
	public function destroyAll(Request $request)
	{
		if(!Auth::user()->hasRole('post-admin|superadministrator')) abort(403);
		if(empty($request->ids)) echo json_encode(['status'=>0,'message'=>'آیتم های مورد نظر حذف نشد!']);

		Post::whereIn('id',explode(',', $request->ids))->delete();

		session()->flash('success-message','همه ی آیتم ها با موفقیت حذف شدند!');

		echo json_encode(['status'=>1,'message'=>'آیتم های مورد نظر حذف شد!']);
    }

	/**
	 * @param $user_id
	 */
	public function exportPdf($user_id)
	{
		$posts = Post::whereUserId($user_id)->get();

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

		// set header and footer fonts
//		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//		// set default monospaced font
//		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//		// set margins
//		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
//		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
//		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language dependent data:
		$lg = Array();
		$lg['a_meta_charset'] = 'UTF-8';
		$lg['a_meta_dir'] = 'rtl';
		$lg['a_meta_language'] = 'fa';
		$lg['w_page'] = 'page';

		// set some language-dependent strings (optional)
		$pdf->setLanguageArray($lg);

		// set font
		$pdf->SetFont('dejavusans', '', 12);

		// add a page
		$pdf->AddPage();

		// Persian and English content
		$view = view('post.pdf', compact('posts'))->render();
//		return $view;
		$pdf->WriteHTML($view, true, 0, true, 0);

		//Close and output PDF document
		$pdf->Output('posts.pdf', 'I');
    }
}
