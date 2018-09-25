<?php

require "init.php";

$username = $_POST['username'];
$password = $_POST['password'];

// lookup the user IDs by username
$userId = $redis->executeRaw(["GET", "user_$username"]);

if ($userId) {
    // user ID exists => continue with the login flow
    $realPassword = $redis->executeRaw(["HGET", $userId, "password"]);
    if ($password === $realPassword) {
        doLogin($userId);
    } else {
        http_response_code(401);
        echo 'This account already exists and entered password is incorrect!';
        exit;
    }
} else {
    // user ID does not exist => continue with the register flow
    // obtain new user ID
    $userId = "user_" . $redis->executeRaw(["INCR", "user_sequence"]);

    // store this user account into a hash
    $redis->executeRaw(["HMSET", $userId, "username", $username, "password", "$password"]);

    // store the user ID into a hash - this is needed to lookup user IDs by usernames
    $redis->executeRaw(["SET", "user_$username", $userId]);

    // login the user
    doLogin($userId);
}

function doLogin($userId) {
    global $redis;

    // calculate random user secret
    $rand = rand(0, PHP_INT_MAX) . $userId;
    $authSecret = hash('sha256', $rand);

    // delete the old auth secret (in case it exists)
    $redis->executeRaw(["HDEL", $userId, "authSecret"]);

    // update the auth secret stored in the user hash
    $redis->executeRaw(["HSET", $userId, "authSecret", $authSecret]);

    // store the user ID into a hash - this is needed to lookup user IDs by user secrets
    $redis->executeRaw(["SET", "authSecret_$authSecret", $userId]);

    setcookie("auth", $authSecret, time() + 3600 * 24 * 365);
}
