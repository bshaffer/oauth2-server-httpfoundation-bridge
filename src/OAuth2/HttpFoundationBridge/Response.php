<?php

namespace OAuth2\HttpFoundationBridge;

use Symfony\Component\HttpFoundation\JsonResponse;
use OAuth2\ResponseInterface;

/**
 *
 */
 class Response extends JsonResponse implements ResponseInterface
 {
    public function addParameters(array $parameters)
    {
        // if there are existing parametes, add to them
        if ($this->content && $data = json_decode($this->content, true)) {
            $parameters = array_merge($data, $parameters);
        }

        // this will encode the php array as json data
        $this->setData($parameters);
    }

    public function addHttpHeaders(array $httpHeaders)
    {
        foreach ($httpHeaders as $key => $value) {
            $this->headers->set($key, $value);
        }
    }

    public function getParameter($name)
    {
        if ($this->content && $data = json_decode($this->content, true)) {
            return isset($data[$name]) ? $data[$name] : null;
        }
    }

    public function setError($statusCode, $name, $description = null, $uri = null)
    {
        $this->setStatusCode($statusCode);
        $this->addParameters(array_filter(array(
            'error'             => $name,
            'error_description' => $description,
            'error_uri'         => $uri,
        )));
    }

    public function setRedirect($statusCode = 302, $url, $state = null, $error = null, $errorDescription = null, $errorUri = null)
    {
        $this->setStatusCode($statusCode);
        $this->setContent(null);

        $query = array(
            'state'             => $state,
            'error'             => $error,
            'error_description' => $errorDescription,
            'error_uri'         => $errorUri
        );

        if ($queryStr = http_build_query(array_filter($query))) {
            $url .= (false === strpos($url, '?') ? '?' : '&').$queryStr;
        }

        $this->headers->set('Location', $url);
    }
 }
