<?php

namespace OAuth2\HttpFoundationBridge;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
 class Server extends \OAuth2_Server
 {
    public function handleTokenRequest(\OAuth2_RequestInterface $request, \OAuth2_ResponseInterface $response)
    {
        parent::handleTokenRequest($request, $response);
        return $this->createResponse($response);
    }

    public function handleAuthorizeRequest(\OAuth2_RequestInterface $request, \OAuth2_ResponseInterface $response, $is_authorized, $user_id = null)
    {
        $response = parent::handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
        return $this->createResponse($response);
    }

    public function getResponse()
    {
        return $this->createResponse(parent::getResponse());
    }

    private function createResponse(\OAuth2_Response $response)
    {
        return new JsonResponse($response->getParameters(), $response->getStatusCode(), $response->getHttpHeaders());
    }
 }
