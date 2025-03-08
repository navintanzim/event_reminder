<?php

return [
    'sender_email' => env('sender_email','<tanzimndub@gmail.com>'),
    'device_access_token_url' => env('device_access_token_url','https://idpific.oss.net.bd/realms/test/protocol/openid-connect/token'),
    'device_access_client_id' => env('device_access_client_id','nodejs-app-client'),
    'device_access_client_secret' => env('device_access_client_secret','KZyJQPa01R01H6aNnRvRcD9sCDkPnkjX'),
    'firebase_device_token_url' => env('firebase_device_url','https://event-feedback.ba-systems.com/api/device_token/one/')
];