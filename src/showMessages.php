<?php

require "init.php";

$userId = loadCurentUserId($_COOKIE['auth']);

if (!$userId) {
    http_response_code(401);
    exit;
}

// get 10 latest messages
$messages = $redis->executeRaw(["LRANGE", "messages", "0", "10"]);
$messages = array_reverse($messages);

foreach ($messages as $messageId) {
    // get all properties of the message
    $message = [];
    $message["text"] = $redis->executeRaw(["HGET", $messageId, "text"]);
    $message["time"] = $redis->executeRaw(["HGET", $messageId, "time"]);

    // add the author's username to the message array
    $message['username'] = $redis->executeRaw(["HGET", $messageId, "username"]);

    printMessage($message);
}

function printMessage(array $message)
{
    echo "<table style=\"width:100%\">"
        . "<tr class='infoRow'>"
        . "<td class='userColumn'>" . $message['username'] . "</td>"
        . "<td class='timeColumn'>" . date('m/d/Y H:i:s', $message['time']) . "</td>"
        . "</tr>"
        . "<tr class='messageRow'>"
        . "<td class='messageColumn'>" . $message['text'] . "</td>"
        . "</tr>"
        . "</table>";
}
