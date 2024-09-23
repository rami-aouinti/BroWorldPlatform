<?php

declare(strict_types=1);
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

$key = 'aVerySecretKey';
$payload = [
    "mercure" => ["publish" => ["*"]]
];

$jwt = JWT::encode($payload, $key, 'HS256');
echo $jwt;
