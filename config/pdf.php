<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => env('APP_NAME', 'Deslogy'),
	'subject'               => '',
	'keywords'              => '',
	'creator'               => env('APP_NAME', 'Deslogy'),
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,


    'default_font_size'          => '12',
    'default_font'               => 'sans-serif',
    'margin_left'                => 5,
    'margin_right'               => 5,
    'margin_top'                 => 10,
    'margin_bottom'              => 5,
    'margin_header'              => 0,
    'margin_footer'              => 0,
    'orientation'                => 'P',
    'title'                      => env('APP_NAME', 'Deslogy'),
    
    'watermark'                  => '',
    'show_watermark'             => false,
    'show_watermark_image'       => false,
    'watermark_font'             => 'sans-serif',
	
    'watermark_text_alpha'       => 0.1,
    'watermark_image_path'       => '',
    'watermark_image_alpha'      => 0.2,
    'watermark_image_size'       => 'D',
    'watermark_image_position'   => 'P',
    'custom_font_dir'            => '',
    'custom_font_data'           => [],
    'auto_language_detection'    => false,
    'temp_dir'                   => storage_path('app'),
    'pdfa'                       => false,
    'pdfaauto'                   => false,
    'use_active_forms'           => false,


	'icc_profile_path'      => '',
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'bangla' => [
			'R'  => 'SolaimanLipi_22-02-2012.ttf',    // regular font
			'B'  => 'SolaimanLipi_Bold_10-03-12.ttf',       // optional: bold font
			'I'  => 'SolaimanLipi_22-02-2012.ttf',     // optional: italic font
			'BI' => 'SolaimanLipi_Bold_10-03-12.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,
			'useKashida' => 75,
		]
		// ...add as many as you want.
	]
];