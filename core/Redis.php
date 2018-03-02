<?php

class Redis
{
    protected static $redis;

    /**
     * redis连接
     */
    protected static function init()
    {
        $client = new Predis\Client(require ROOT.'/config/redis.php');
        self::$redis = $client;
    }

    /**
     * 设置值
     * @param string $key 键名
     * @param string $key 键名
     * @param int $time 缓存时间,单位s
     * @return void
     */
    public static function set(string $key, string $value, int $time = 0)
    {
        self::init();
        if (!$time) {
            self::$redis->set($key, $value);
        } else {
            self::$redis->setex($key, $time, $value);
        }
    }

    /**
     * 获取值
     * @param string $key 键名
     * @return string
     */
    public static function get(string $key)
    {
        self::init();
        return self::$redis->get($key);
    }

    /**
     * 移除值
     * @param string $key 键名
     * @return void
     */
    public static function delete(string $key)
    {
        self::init();
        return self::$redis->del($key);
    }
}