<?php

class RedisHelper
{
    private static function cache(): CRedisCache
    {
        return Yii::app()->cache;
    }
    private static function prefix(): string
    {
        return Yii::app()->cache->keyPrefix;
    }

    public static function setArray($collectionKey, array $arr, int $ttl = -1)
    {
        $args = [];
        foreach ($arr as $key => $item) {
            $args = [...$args, $key, is_array($item) ? json_encode($item) : $item];
        }
        static::cache()->executeCommand('HMSET', [$collectionKey, ...$args]);
        if ($ttl > 0) static::cache()->executeCommand('EXPIRE', [$collectionKey, $ttl]);
    }

    public static function getArray(string $key): array
    {
        $fields = static::cache()->executeCommand('HGETALL', [$key]);
        $associative = [];
        for ($i = 0; $i < count($fields); $i += 2) {
            $associative [$fields[$i]] = $fields[$i + 1];
        }
        return $associative;
    }
}