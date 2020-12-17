<?php
namespace Synergy\lander\app\components\http;
use Synergy\lander\app\BaseComponent;
use Synergy\lander\app\components\http\request\GetRequest;
use Synergy\lander\app\components\http\request\PostRequest;
use Synergy\lander\app\components\http\request\ServerRequest;

/**
 * Class HttpRequest
 *
 * @property GetRequest $get
 * @property PostRequest $post
 * @property ServerRequest $server
 *
 * @package Synergy\lander\app\components\http
 */
class HttpRequest extends BaseComponent
{
    private $_get = null;
    private $_post = null;
    private $_server = null;

    public function setGet($get)
    {
        $this->_get = new GetRequest(['data' => $get]);
    }

    public function get($key, $default = null)
    {
        return $this->_get->$key ? $this->_get->$key : $default;
    }

    public function getGet()
    {
        return $this->_get;
    }

    public function setPost($post)
    {
        $this->_post = new PostRequest(['data' => $post]);
    }

    public function getPost()
    {
        return $this->_post;
    }

    public function post($key, $default = null)
    {
        return $this->_post->$key ? $this->_post->$key : $default;
    }

    public function getServer()
    {
        return $this->_server;
    }

    public function setServer($server)
    {
        $this->_server = new ServerRequest(['data' => $server]);
    }

    public function server($key, $default = null)
    {
        return $this->_server->$key ? $this->_server->$key : $default;
    }

    public function init()
    {
        if (null === $this->_get) $this->_get = new GetRequest();
        if (null === $this->_post) $this->_post = new PostRequest();
        if (null === $this->_server) $this->_server = new ServerRequest();
    }
}