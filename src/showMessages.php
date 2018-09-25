<?php

use Predis\Collection\Iterator;

require "init.php";

$username = verify_auth_secret($_COOKIE['auth']);

if (!$username) {
    http_response_code(401);
    exit;
}

// get messages
$messages = new Iterator\ListKey($redis, 'messages');

foreach ($messages as $message) {
    // get all properties of the message
    $message = json_decode($message, true);

    printMessage($message);
}

function printMessage(array $message) {
    echo "<table style=\"width:100%\">"
        ."<tr class='infoRow'>"
        ."<td class='userColumn'>" . $message['username'] . "</td>"
        ."<td class='timeColumn'>". date('m/d/Y H:i:s', $message['time']) ."</td>"
        ."</tr>"
        ."<tr class='messageRow'>"
        ."<td class='messageColumn'>". $message['text'] ."</td>"
        ."</tr>"
        ."</table>";
}
