<?php

require "../vendor/autoload.php";


$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);

function loadCurentUserId($authSecret) {
    global $redis;

    // empty auth secret means the user is logged out
    if ($authSecret == '') {
        return null;
    }

    // use the auth secret to get the user ID
	$userId = $redis->hget("users", $authSecret);

    if (isset($userId)) {
        // cross check that this auth secret is also stored in the user hash
        $userAuthSecret = $redis->hget("user:" . $userId, "authSecret");

        if ($userAuthSecret != $authSecret) {
            return null;
        }

        return $userId;
    }

    // no user ID was found by the auth secret
    return null;
}
