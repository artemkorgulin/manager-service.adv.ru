<?php
namespace Synergy\lander\app\components\http\request;
use Synergy\lander\app\components\http\HttpRequestStorage;

class ServerRequest extends HttpRequestStorage
{
    public function getIp()
    {
        $search = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        foreach ($search as $key)
            if (isset($this->_data[$key]) && filter_var($this->_data[$key], FILTER_VALIDATE_IP))
                return $this->_data[$key];

        return null;
    }

    public static function defaultData()
    {
        return $_SERVER;
    }
}