<?php

namespace App\Providers;

use Phalcon\Session\Adapter\Redis as RedisSession;

class Session extends Provider
{

    protected $serviceName = 'session';

    public function register()
    {
        $this->di->setShared($this->serviceName, function () {

            $config = $this->getShared('config');

            $session = new RedisSession([
                'host' => $config->redis->host,
                'port' => $config->redis->port,
                'auth' => $config->redis->auth,
                'index' => $config->session->db,
                'lifetime' => $config->session->lifetime,
            ]);

            $session->start();

            return $session;
        });
    }

}