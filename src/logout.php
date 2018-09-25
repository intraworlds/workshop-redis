<?php

require "init.php";

$userId = loadCurentUserId($_COOKIE['auth']);

if (!$userId) {
    http_response_code(401);
    exit;
}

// delete the old auth secret
$redis->executeRaw(["HDEL", $userId, "authSecret"]);

// set this user's auth secret to empty
$redis->executeRaw(["DEL", "authSecret_$authSecret"]);

setcookie('auth', '', 1);
