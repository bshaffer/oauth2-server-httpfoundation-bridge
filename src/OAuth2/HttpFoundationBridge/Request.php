<?php

namespace OAuth2\HttpFoundationBridge;

use Symfony\Component\HttpFoundation\Request as BaseRequest;
use OAuth2\RequestInterface;

/**
 *
 */
 class Request extends BaseRequest implements RequestInterface
 {
    public function query($name, $default = null)
    {
        return $this->query->get($name, $default);
    }

    public function request($name, $default = null)
    {
        return $this->request->get($name, $default);
    }

    public function server($name, $default = null)
    {
        return $this->server->get($name, $default);
    }

    public function headers($name, $default = null)
    {
        return $this->headers->get($name, $default);
    }

    public function getAllQueryParameters()
    {
        return $this->query->all();
    }

    public static function createFromRequest(BaseRequest $request)
    {
        return new static($request->query->all(), $request->request->all(), $request->attributes->all(), $request->cookies->all(), $request->files->all(), $request->server->all(), $request->getContent());
    }
 }
