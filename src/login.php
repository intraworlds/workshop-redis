<?php

exit; // EXTENDED TASK: delete this line to complete the extended task

require "init.php";

$username = $_POST['username'];
$password = $_POST['password'];

// lookup the user IDs by username
// $userId = ___________________ (EXTENDED TASK)

if ($userId) {
    // user ID exists => continue with the login flow
    // $realPassword = __________________ (EXTENDED TASK)
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
    // $userId = _________________ (EXTENDED TASK)
    // store this user account into a hash
    // ________________________ (EXTENDED TASK)
    // store the user ID into a hash - this is needed to lookup user IDs by usernames
    // ________________________ (EXTENDED TASK)

    // login the user
    doLogin($userId);
}

function doLogin($userId) {
    global $redis;

    // calculate random user secret
    $rand = rand(0, PHP_INT_MAX) . $userId;
    $authSecret = hash('sha256', $rand);

    // delete the old auth secret (in case it exists)
    // ________________________ (EXTENDED TASK)

    // update the auth secret stored in the user hash
    // ________________________ (EXTENDED TASK)

    // store the user ID into a hash - this is needed to lookup user IDs by user secrets
    // ________________________ (EXTENDED TASK)

    setcookie("auth", $authSecret, time() + 3600 * 24 * 365);
}
