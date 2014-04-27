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
        $url = parse_url($url);
        parse_str(isset($url['query']) ? $url['query'] : '', $url['query']);

        $this->setStatusCode($statusCode);
        $this->setContent(null);

        if ($error) {
            $url['query']['error'] = $error;
        }

        if ($errorDescription) {
            $url['query']['error_description'] = $errorDescription;
        }

        if ($error) {
            $url['query']['error_uri'] = $errorUri;
        }

        $redirect = sprintf( '%s://%s%s', $url['scheme'], $url['host'], $url['path'] );
        if ($query = http_build_query($url['query'])) {
            $redirect .= '?'.$query;
        }

        $this->headers->set('Location', $redirect);
    }
 }
