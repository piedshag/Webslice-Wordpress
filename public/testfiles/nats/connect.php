<?php
$response = [];

$f = fsockopen(
    "unix://\x00nats_invalidator_socket_addr",
-1,
    $errno,
    $errstr,
    2
);

if (!$f) {
    $response["socketopen"] = array(
        "error"=> $errstr,
        "errno"=> $errno,
        "success"=> false,
    );
} else {
    $response["socketopen"] = array(
        "error" => "",
        "errno" => 0,
        "success" => true,
    );

    $r = fwrite($f, "PING\r\n", 6);
    $response["socketwrite"] = array(
        "written" => $r,
    );

    $c = fclose($f);
    $response["socketclose"] = array(
        "closed" => $c,
    );
}



// Set the content-type header
header("Content-type: application/json");

// Output some json
echo json_encode($response);

