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
$last = $redis->llen("messages");
$messageId = ++$last;

// insert the message into its own hash
$redis->hmset("message:" . $messageId, array(
	"time" => $time,
	"text" => $text,
	"userId" => $userId
));

// push the message into the list of message IDs
$redis->lpush("messages", array($messageId));