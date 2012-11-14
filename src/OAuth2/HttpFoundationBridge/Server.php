<?php

namespace OAuth2\HttpFoundationBridge;

use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
 class Server extends \OAuth2_Server
 {
    public function handleGrantRequest(\OAuth2_RequestInterface $request)
    {
        $response =  parent::handleGrantRequest($request);
        return $this->createResponse($response);
    }

    public function handleAuthorizeRequest(\OAuth2_RequestInterface $request, $is_authorized, $user_id = null)
    {
        $response = parent::handleAuthorizeRequest($request, $is_authorized, $user_id);
        return $this->createResponse($response);
    }

    public function getResponse()
    {
        return $this->createResponse(parent::getResponse());
    }

    private function createResponse(\OAuth2_Response $response)
    {
        return new Response($response->getResponseBody(), $response->getStatusCode(), $response->getHttpHeaders());
    }
 }
