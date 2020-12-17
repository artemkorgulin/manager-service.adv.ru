<?php
namespace Synergy\lander\app\components\http\request;
use Synergy\lander\app\components\http\HttpRequestStorage;

class PostRequest extends HttpRequestStorage
{
    public static function defaultData()
    {
        return $_POST;
    }
}