<?php

require "init.php";

$userId = loadCurentUserId($_COOKIE['auth']);

if (!$userId) {
    http_response_code(401);
    exit;
}

// get 10 latest messages
$messages = $redis->lrange("messages", 0, 10);

foreach ($messages as $id) {
    // get all properties of the message
	$message = $redis->hgetall("message:" . $id);


	if(isset($message["userId"])){
	    // add the author's username to the message array
	    $message['username'] = $redis->hget("user:" . $message["userId"], "username");
	} else {
		$message['username'] = "Annonymous";
	}


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
