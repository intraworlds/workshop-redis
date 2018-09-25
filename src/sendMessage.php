<?php
define('MESSAGE_CAP', 10);

require "init.php";

$username = verify_auth_secret($_COOKIE['auth']);

if (!$username) {
    http_response_code(401);
    exit;
}

// redis can store any string value, for complex data is better use serialization
// like a JSON than native Redis structures (especially if you need simple list)
$message = [
    'time' => time(),
    'text' => $_POST['text'],
    'username' => $username,
];

// this is much more convenient for list of messages, store whole message in the
// simple list - don't pollute Redis DB
$redis->lpush('messages', json_encode($message));

// this will make sure that list is capped on 10 messages (no DB overflow)
$redis->ltrim('messages', 0, MESSAGE_CAP - 1);
