<?php

class cache {
    const RETRY_WAIT = 500;
    const RETRY_ATTEMPTS = 3;

    protected static $instances = array();

    public static function get_instance() {
        if(empty(self::$instances)) {
            self::setup_from_config();
        }
    }

    private static function setup_from_config() {
        $name = MEMCACHE_IP . MEMCACHE_PORT;
        $memcache = new Memcached($name);
        $memcache->setOption(Memcached::OPT_RECV_TIMEOUT, 1000);
        $memcache->setOption(Memcached::OPT_SEND_TIMEOUT, 1000);
        $memcache->setOption(Memcached::OPT_TCP_NODELAY, true);
        $memcache->setOption(Memcached::OPT_SERVER_FAILURE_LIMIT, 50);
        $memcache->setOption(Memcached::OPT_CONNECT_TIMEOUT, 500);
        $memcache->setOption(Memcached::OPT_RETRY_TIMEOUT, 300);
        $memcache->addServer(MEMCACHE_IP, MEMCACHE_PORT);

        self::$instances[] = $memcache;
    }

    public static function __callStatic($name, $_args) {
        self::get_instance();
        $args = $_args;
        $pool = array_shift($args);

        $attempt = 0;

        do {
            try {
                $retry = false;
                if(method_exists('Memcached',$name)){
                    $args[0] = self::key($pool, $args[0]);
                    $result = call_user_func_array(array(&self::$instances[0], $name),$args);
                }else{

                }
            } catch (Exception $e) {
                $retry = true;

                if($retry && $attempt + 1 < RETRY_ATTEMPTS) usleep(RETRY_WAIT);
                else throw $e;

            }
        }while($retry && $attempt++ < RETRY_ATTEMPTS);

        return $result;
    }

    private static function key($pool, $key) {
        return $pool.'_'.$key;
    }

    private static function hash_servers() {

    }
}