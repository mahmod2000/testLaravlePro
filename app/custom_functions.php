<?php
/**
 * Some functions
 * User: mahmoud
 * Date: 10/5/17
 * Time: 15:37
 */

namespace App;

use Intervention\Image\Facades\Image;

class custom_functions
{
	public static function resizeImages($request, $public_path = 'images/post/', $image_name)
	{
		$image = Image::make($request->image);

		$ext = $request->image->getClientOriginalExtension();

		$original_size = $image_name.'.'.$ext;

		$image_original = $image->resize(900,300);
		$image_original->save(public_path($public_path).$original_size);

		// 900 * 300
		$image_900_300 = $image_name.'-'.'900-300'.'.'.$ext;
		$image1 = $image->resize(900,300);
		$image1->save(public_path($public_path).$image_900_300);

		// 400 * 500
		$image_400_500 = $image_name.'-'.'400-500'.'.'.$ext;
		$image2 = $image->resize(400,500);
		$image2->save(public_path($public_path).$image_400_500);

		// 100 * 100
		$image_100_100 = $image_name.'-'.'100-100'.'.'.$ext;
		$image3 = $image->resize(100,100);
		$image3->save(public_path($public_path).$image_100_100);

		return $original_size;
	}
}