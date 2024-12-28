<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'NotoSansArabic' => [
            'R'  => 'NotoSansArabic-Regular.ttf',    // Regular font
            'B'  => 'NotoSansArabic-Bold.ttf',       // Bold font (optional)
            'I'  => 'NotoSansArabic-Italic.ttf',     // Italic font (optional)
            'BI' => 'NotoSansArabic-BoldItalic.ttf', // Bold Italic font (optional)
            'useOTL' => 0xFF,    // Required for complex languages like Arabic
            'useKashida' => 75,  // Adjusts the length of the Kashida (optional)
        ],
        // ... add more fonts as needed
    ],
];
