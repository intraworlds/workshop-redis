<?php

require "../vendor/autoload.php";


$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host' => 'localhost',
    'port'   => 6379,
    'async' => false,
    'throw_errors' => true
]);

function loadCurentUserId($authSecret) {
    global $redis;

    // empty auth secret means the user is logged out
    if ($authSecret == '') {
        return null;
    }

    // use the auth secret to get the user ID
    $userId = $redis->executeRaw(["GET", "authSecret_$authSecret"]);

    if ($userId) {
        // cross check that this auth secret is also stored in the user hash
        $userAuthSecret = $redis->executeRaw(["HGET", $userId, "authSecret"]);
        if ($userAuthSecret != $authSecret) {
            return null;
        }

        return $userId;
    }

    // no user ID was found by the auth secret
    return null;
}
