<?php
define('SESSION_TTL', 3600); // 1 hour

require "init.php";

$username = $_POST['username'];
$password = $_POST['password'];

// lookup the user by username
$isRegistered = $redis->hexists('users', $username);

if ($isRegistered) {
    // user exists => continue with the login flow
    $hash = $redis->hget('users', $username);
    if (password_verify($password, $hash)) {
        doLogin($username);
    } else {
        http_response_code(401);
        echo 'This account already exists and entered password is incorrect!';
        exit;
    }
} else {
    // user does not exist => continue with the register flow
    $hash = password_hash($password, PASSWORD_DEFAULT); // always store only a hash of the password - USE secure methods
    $redis->hset('users', $username, $hash);

    // login the user
    doLogin($username);
}

function doLogin($username) {
    global $redis;

    // calculate random user secret
    $authSecret = bin2hex(random_bytes(16)); // use cryptographically safe functions (rand() is too predictable)

    // save session with expiration
    $redis->setex($authSecret, SESSION_TTL, $username);

    setcookie("auth", $authSecret, time() + SESSION_TTL, '', '', false, true); // make sure that session ID is not readable by JS
}
