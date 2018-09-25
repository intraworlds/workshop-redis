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
$messageId = "message_" . $redis->executeRaw(["INCR", "message_sequence"]);

// insert the message into its own hash
$username = $redis->executeRaw(["HGET", $userId, "username"]);
$redis->executeRaw(["HMSET", $messageId, "time", $time, "text", "$text", "username", $username]);

// push the message into the list of message IDs
$redis->executeRaw(["RPUSH", "messages", $messageId]);
