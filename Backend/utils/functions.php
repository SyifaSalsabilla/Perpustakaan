<?php

function sendResponse($status, $message, $data = null)
{
    $response = array(
        "status" => $status,
        "message" => $message,
        "data" => $data
    );

    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
