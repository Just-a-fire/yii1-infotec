<?php

return [
	'class' => 'CRedisCache',
    'hostname' => getenv('REDIS_HOSTNAME'),
    'port' => 6379,
    'database' => 0,
    // 'options' => STREAM_CLIENT_CONNECT,
    // 'username' => 'default',
    // 'password' => getenv('REDIS_PASSWORD')
];