<?php
function loadEnv(/* $file = '.env' */)
{
    //$file = '/.env';
    $file = dirname(__DIR__) . '/../.env';
    $env = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $env[trim($key)] = trim($value);
        }
    }
    return $env;
}

$env = loadEnv();
