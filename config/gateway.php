<?php

return [
    'services' => [
        'authsvc' => [
            'url' => 'https://jsonplaceholder.typicode.com',
            'port' => 443,
            'timeout' => 10,
        ],
        'usersvc' => [
            'url' => 'http://127.0.0.1',
            'port' => 8001,
            'timeout' => 10,
        ],
        'todosvc' => [
            'url' => 'http://127.0.0.1',
            'port' => 8000,
            'timeout' => 10,
        ],
    ],
];
