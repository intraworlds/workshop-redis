<?php

require "init.php";

$userId = loadCurentUserId($_COOKIE['auth']);

if (!$userId) {
    http_response_code(401);
    exit;
}

$time = time();
$text = $_POST['text'];

// get the ID of the message
// $messageId = _______________ (BASIC TASK)

// insert the message into its own hash
// _______________ (BASIC TASK)

// push the message into the list of message IDs
// _______________ (BASIC TASK)
