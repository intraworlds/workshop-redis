<?php

require "../vendor/autoload.php";


$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);

function loadCurentUserId($authSecret) {
    return 1; // EXTENDED TASK: delete this line to complete the extended task

    global $redis;

    // empty auth secret means the user is logged out
    if ($authSecret == '') {
        return null;
    }

    // use the auth secret to get the user ID
    // $userId = _____________ (EXTENDED TASK)
    if ($userId) {
        // cross check that this auth secret is also stored in the user hash
        // $userAuthSecret = _____________ (EXTENDED TASK)
        if ($userAuthSecret != $authSecret) {
            return null;
        }

        return $userId;
    }

    // no user ID was found by the auth secret
    return null;
}
