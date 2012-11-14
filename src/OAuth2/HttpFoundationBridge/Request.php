<?php

namespace OAuth2\HttpFoundationBridge;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 *
 */
 class Request extends BaseRequest implements \OAuth2_RequestInterface
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
 }
