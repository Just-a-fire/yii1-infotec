<?php

class RedisHelper
{
    /*
    * @var CRedisCache
    */
    private $_cache;
    
    public function __construct()
    {
        $this->_cache = Yii::app()->cache;
        if (!$this->_cache) throw new Exception('Для работы с классом нужно подключение к кешу');
    }

    public function setArray($collectionKey, array $arr)
    {
        $args = [];
        foreach ($arr as $key => $item) {
            $args = [...$args, $key, is_array($item) ? json_encode($item) : $item];
        }
        $this->_cache->executeCommand('HMSET', [$collectionKey, ...$args]);
        // Yii::app()->cache->executeCommand('hmset', [$key, 'key1', 'val1', 'key2', 'val2']);
    }

    public function getArray(string $key): array
    {
        $fields = $this->_cache->executeCommand('HGETALL', [$key]);
        $associative = [];
        for ($i = 0; $i < count($fields); $i+=2) {
            $associative [$fields[$i]] = $fields[$i + 1];
        }
        return $associative;
    }
}