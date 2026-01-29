<?php

return [
	'class' => 'CRedisCache',
    'hostname' => getenv('REDIS_HOSTNAME'),
    'port' => getenv('REDIS_PORT'),
    'database' => 0,
    // 'options' => STREAM_CLIENT_CONNECT,
    // 'username' => 'default',
    'password' => getenv('REDIS_PASSWORD')
];