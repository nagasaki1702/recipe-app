<?php

return array(
    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,
    'options' => array(
        // この２行がちゃんと指定されていなかったから？？'fonts/'がおかしかったのかな？今となってはわからぬ・・
        'fontDir' => storage_path('fonts/'), 
        'font_cache' => storage_path('fonts/'),
        // この２行がちゃんと指定されていなかったから？？'fonts/'がおかしかったのかな？今となってはわからぬ・・
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => realpath(base_path()),
        'default_font' => 'ipag',
        
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []]
        ],
        'log_output_file' => null,
        'enable_font_subsetting' => true,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true,
    ),
);
