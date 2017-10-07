<?php
return [
	'mode'                 => '',
	'format'               => 'A4',
	'default_font_size'    => '12',
	'default_font'         => 'IranSas',
	'margin_left'          => 10,
	'margin_right'         => 10,
	'margin_top'           => 10,
	'margin_bottom'        => 10,
	'margin_header'        => 0,
	'margin_footer'        => 0,
	'orientation'          => 'P',
	'title'                => 'Laravel mPDF',
	'author'               => '',
	'watermark'            => '',
	'show_watermark'       => false,
	'display_mode'         => 'fullpage',
	'watermark_text_alpha' => 0.1,
	'custom_font_path' => base_path('/public/fonts/'), // don't forget the trailing slash!
	'custom_font_data' => [
		'IranSas' => [
			'R'  => 'IRANSansWeb.ttf',    // regular font
			'B'  => 'IRANSansWeb_Bold.ttf',       // optional: bold font
		]
	]
];