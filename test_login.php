<?php
$url = 'http://localhost/api/v1/auth/login';
$data = ['email' => 'robert.hofer.zuerich@bluewin.ch', 'password' => 'password'];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\nUser-Agent: Dart/3.3 (dart:io)\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true,
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;

