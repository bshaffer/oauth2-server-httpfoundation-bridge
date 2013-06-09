<?php

namespace OAuth2\HttpFoundationBridge;

use Symfony\Component\HttpFoundation\JsonResponse;
use OAuth2\Server as OAuth2Server;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;

/**
 *
 */
 class Server extends OAuth2Server
 {
    public function handleTokenRequest(RequestInterface $request)
    {
        $response =  parent::handleTokenRequest($request);
        return $this->createResponse($response);
    }

    public function handleAuthorizeRequest(RequestInterface $request, $is_authorized, $user_id = null)
    {
        $response = parent::handleAuthorizeRequest($request, $is_authorized, $user_id);
        return $this->createResponse($response);
    }

    public function getResponse()
    {
        return $this->createResponse(parent::getResponse());
    }

    private function createResponse(ResponseInterface $response)
    {
        return new JsonResponse($response->getParameters(), $response->getStatusCode(), $response->getHttpHeaders());
    }
 }
