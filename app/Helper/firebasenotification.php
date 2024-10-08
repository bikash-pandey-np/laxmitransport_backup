<?php

use \Illuminate\Support\Str;

function fireBaseNotificationForMessage($device_token, $title, $message)
{
    if (!is_array($device_token)) {
        $device_token = [$device_token];
    }

    $dataArray = [
        'type' => "message",
        'id' => $message->id
    ];

    $data = [
        "data" => $dataArray,
        "registration_ids" => $device_token,
        "notification" => [
            "title" => $title,
            "body" => Str::limit($message->message,150),
        ]
    ];

    firebaseCall($data);

}

function fireBaseJustNotification($device_token, $title, $message)
{
    if (!is_array($device_token)) {
        $device_token = [$device_token];
    }

    $dataArray = [

    ];

    $data = [
        "data" => $dataArray,
        "registration_ids" => $device_token,
        "notification" => [
            "title" => $title,
            "body" => Str::limit($message),
        ]
    ];

    firebaseCall($data);

}

function fireBaseNotificationForCreateOrder($device_token, $title, $order)
{
    if (!is_array($device_token)) {
        $device_token = [$device_token];
    }

    $dataArray = [
        'type' => "order",
        'id' => $order->id
    ];

    $data = [
        "data" => $dataArray,
        "registration_ids" => $device_token,
        "notification" => [
            "title" => $title,
            "body" => "You have been assign new order.",
        ]
    ];

    firebaseCall($data);

}

function fireBaseNotificationForCreateBiding($device_token, $title, $biding)
{
    if (!is_array($device_token)) {
        $device_token = [$device_token];
    }

    $dataArray = [
        'type' => "biding",
        'id' => $biding->id
    ];

    $data = [
        "data" => $dataArray,
        "registration_ids" => $device_token,
        "notification" => [
            "title" => $title,
            "body" => "New bid has available.",
        ]
    ];

    firebaseCall($data);

}

function firebaseCall($data){

    $SERVER_API_KEY = "AAAAWvKrueU:APA91bFHCVfUHkC9UzVGcBLWXLzoVIMI818gH6tbDcXJ1wbkwGgCwofLNhv2ouD82NcG91FRppVqb703cF_LS6wamm6mnuywhQviu7BTIgH7MxQQ_V9VvkS9wK4Sw19URKhWW33t_d2x";

    $dataString = json_encode($data);

    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    curl_exec($ch);
}

