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

    public function setError($statusCode, $error, $description = null, $uri = null)
    {
        $this->setStatusCode($statusCode);

        if (!is_null($uri)) {
            if (strlen($uri) > 0 && $uri[0] == '#') {
                 // we are referencing an oauth bookmark (for brevity)
                 $uri = 'http://tools.ietf.org/html/rfc6749' . $uri;
             }
        }

        $this->headers->set('Cache-Control', 'no-store');

        $this->addParameters(array_filter(array(
            'error'             => $error,
            'error_description' => $description,
            'error_uri'         => $uri,
        )));
    }

    public function setRedirect($statusCode = 302, $url, $state = null, $error = null, $errorDescription = null, $errorUri = null)
    {
        $this->setStatusCode($statusCode);

        if (!is_null($state)) {
            $this->addParameters(array('state' => $state));
        }

        if (!is_null($error)) {
            $this->setError($statusCode, $error, $errorDescription, $errorUri);
        }

        if ($this->content && $data = json_decode($this->content, true)) {
            // add parameters to URL redirection
            $parts = parse_url($url);
            $sep = isset($parts['query']) && count($parts['query']) > 0 ? '&' : '?';
            $url .= $sep . http_build_query($data);
        }

        $this->headers->set('Location', $url);
    }
 }
