<?php

namespace OAuth2;

use OAuth2\HttpFoundation\Server;
use Symfony\Component\HttpFoundation\Response;

/**
*
*/
class HttpFoundationBridge
{
    /**
     * Create an OAuth2\HttpFoundation\Server instance from an OAuth2_Server instance
     *
     * This will cause the oauth2 server to return an instance of HttpFoundation/Response instead of the
     * OAuth2_Server response object
     *
     * @param $server OAuth2_Server
     * The instance of OAuth2_Server to
     **/
    public static function createServer(\OAuth2_Server $server)
    {
        return new Server($server);
    }

    public static function createResponse(\OAuth2_Request $request)
    {
        return new Response($response->getResponseBody(), $response->getStatusCode(), $response->getHttpHeaders());
    }
}