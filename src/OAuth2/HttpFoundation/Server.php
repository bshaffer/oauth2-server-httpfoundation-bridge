<?php

namespace OAuth2\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
 class Server implements \OAuth2_Controller_AccessControllerInterface,
    \OAuth2_Controller_AuthorizeControllerInterface, \OAuth2_Controller_GrantControllerInterface
 {
    private $server;

    public function __construct(\OAuth2_Server $server)
    {
        $this->server = $server;
    }

    public function getAccessController()
    {
        return $this->server->getAccessController();
    }

    public function getAuthorizeController()
    {
        return $this->server->getAuthorizeController();
    }

    public function getGrantController()
    {
        return $this->server->getGrantController();
    }

    public function handleGrantRequest(\OAuth2_RequestInterface $request)
    {
        $value =  $this->server->handleGrantRequest($request);
        if ($value instanceof \OAuth2_Response) {
            return $this->createResponse($value);
        }
        return $value;
    }

    public function grantAccessToken(\OAuth2_RequestInterface $request)
    {
        return $this->server->grantAccessToken($request);
    }

    public function getClientCredentials(\OAuth2_RequestInterface $request)
    {
        return $this->server->getClientCredentials($request);
    }

    public function handleAuthorizeRequest(\OAuth2_RequestInterface $request, $is_authorized, $user_id = null)
    {
        $value = $this->server->handleAuthorizeRequest($request, $is_authorized, $user_id);
        if ($value instanceof \OAuth2_Response) {
            return $this->createResponse($value);
        }
        return $value;
    }

    public function validateAuthorizeRequest(\OAuth2_RequestInterface $request)
    {
        return $this->server->validateAuthorizeRequest($request);
    }

    public function verifyAccessRequest(\OAuth2_RequestInterface $request)
    {
        return $this->server->verifyAccessRequest($request);
    }

    public function getAccessTokenData($token_param, $scope = null)
    {
        return $this->server->getAccessTokenData($token_param, $scope);
    }

    public function addGrantType(\OAuth2_GrantTypeInterface $grantType)
    {
        return $this->server->addGrantType($grantType);
    }

    public function getResponse()
    {
        return $this->createResponse($this->server->getResponse());
    }

    private function createResponse(\OAuth2_Response $response)
    {
        return new Response($response->getResponseBody(), $response->getStatusCode(), $response->getHttpHeaders());
    }
 }
