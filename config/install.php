<?php
return [
    'php_version' => '8.1',
    'extensions' => [
        'php' => [
            'BCMath',
            'Ctype',
            'Fileinfo',
            'JSON',
            'Mbstring',
            'OpenSSL',
            'PDO',
            'Tokenizer',
            'XML',
            'GD',
            'cURL'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    'permissions' => [
        'Files' => [
            '.env',
        ],
        'Folders' =>
            [
                'public/uploads/avatars',
                'public/uploads/banners',
                'public/uploads/brand',
                'public/uploads/covers',
                'public/uploads/playlists',
                'public/uploads/productions',
                'public/uploads/tracks',
                'storage',
                'storage/framework/',
                'storage/framework/cache',
                'storage/framework/cache/data',
                'storage/framework/sessions',
                'storage/framework/views',
                'storage/logs',
            ],
    ]
];
