<?php

require "init.php";

$userId = loadCurentUserId($_COOKIE['auth']);

if (!$userId) {
    http_response_code(401);
    exit;
}

// delete the old auth secret (in case it exists)
$authSecret = $redis->hget("user" . $userId, "authSecret");
if($authSecret){
	$redis->hdel("users", array($authSecret));
}

// set this user's auth secret to empty
$redis->hset("user:" . $userId, "authSecret", "");


setcookie('auth', '', 1);
