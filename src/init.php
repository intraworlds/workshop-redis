<?php
ini_set('display_errors', 1);
require "../vendor/autoload.php";

$redis = new Predis\Client(
    [
        'tcp://workshop-redis_sentinel_1:26379',
        'tcp://workshop-redis_sentinel_2:26379',
        'tcp://workshop-redis_sentinel_3:26379',
    ],
    ['replication' => 'sentinel', 'service' => 'chatapp']
);

function verify_auth_secret($authSecret) {
    global $redis;

    // empty auth secret means the user is logged out
    if ($authSecret) {
        if ($username = $redis->get($authSecret)) {
            return $username;
        }

        // invalid secret - wait few seconds to defense against brutal force attack
        sleep(3);
    }
    // no user was found by the auth secret
    return null;
}
