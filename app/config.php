<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        'converter' => [
            'defaultFileName' => 'default',
            'baseDirectory' => __DIR__ . '/..' . '/public' . '/',
            'fileExtension' => '.md',
        ],

        'renderer' => [
            'prerenderContent' => false,
            'templateFile' => __DIR__ . '/..' . '/template.html',
            'customData' => require(__DIR__ . '/custom_data.php'),
        ],

        'overrideDefault' => false,
        'exposeToXhr' => true,
    ]
];
