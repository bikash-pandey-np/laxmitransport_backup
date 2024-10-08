<?php

use Carbon\Carbon;
use \Illuminate\Support\Facades\Session;

function format_date($date, $format = 'm/d/Y')
{
    return date($format, strtotime($date));
}

function format_server_to_local($time,$format="H:i"){

    try {
        $timeZone = session('timezone') ?? config('app.timezone');
        $dt = new DateTime($time, new DateTimeZone(config('app.timezone')));
        $dt->setTimezone(new DateTimeZone($timeZone));
        return $dt->format($format);

    } catch (\Exception $e) {
        return $time;
    }
}

function format_local_to_server($time, $format = "H:i:s")
{
    $timeZone = session('timezone') ?? config('app.timezone');
    $dt = new DateTime($time, new DateTimeZone($timeZone));
    $dt->setTimezone(new DateTimeZone(config('app.timezone')));
    return $dt->format($format);
}

function getValue($data, $row, $time = false)
{
    if (old($data)) {
        return old($data);
    } elseif (isset($row)) {
        if ($time) {
            return format_server_to_local($row->{$data});
        }
        return $row->{$data};
    }
    return "";
}

function createAdminNotification($sender, $userIds, $message)
{
    foreach ($userIds as $userId) {
        \App\Models\Notification::create([
            'title' => $message['title'],
            'type' => $message['type'],
            'short_description' => $message['short_description'] ?? "",
            'description' => $message['description'] ?? "",
            'url' => $message['url'] ?? "",
            'seen' => 0,

            'sender_type' => $sender['type'],
            'sender_id' => $sender['id'],

            'receiver_type' => 'super_admin',
            'receiver_id' => $userId,
        ]);
    }
}
