<?php

exit; // EXTENDED TASK: delete this line to complete the extended task

require "init.php";

$userId = loadCurentUserId($_COOKIE['auth']);

if (!$userId) {
    http_response_code(401);
    exit;
}

// delete the old auth secret
// ___________________ (EXTENDED TASK)
// set this user's auth secret to empty
// ___________________ (EXTENDED TASK)

setcookie('auth', '', 1);
