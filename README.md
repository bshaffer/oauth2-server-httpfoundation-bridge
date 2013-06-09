oauth2-server-httpfoundation-bridge
===================================

A bridge to HttpFoundation for oauth2-server-php.

oauth2-server-httpfoundation-bridge is a wrapper for [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php)
which returns HttpFoundation\Response instead of OAuth2_Response, and uses HttpFoundation\Request instead of OAuth2_Request.
If you are integrating oauth2 into a Silex, symfony, or [Laravel 4](http://four.laravel.com) app, (or any app using HttpFoundation), this will make your
application much cleaner

## Creating the request

Creating the response object is the same as before, except now you use the
`OAuth2\HttpFoundationBridge\Request` class:

    $request = OAuth2\HttpFoundationBridge\Request::createFromGlobals();
    $app->run($request);

The Request object is now compatible with both HttpFoundation *and* oauth2-server-php

    // getBaseUrl is unique to HttpFoundation
    $baseUrl = $request->getBaseUrl();

    // call oauth server
    $server->grantAccessToken($request);

If the HttpFoundation request already exists, you can use the static `createFromRequest`
function to build the OAuth2\HttpFoundationBridge\Request instance:

    use OAuth2\HttpFoundationBridge\Request as BridgeRequest;

    // in your controller layer, the $request object is passed in
    public function execute(Request $request)
    {
        //... (instantiate server/response objects)
        $bridgeRequest = BridgeRequest::createFromRequest($request);
        $server->grantAccessToken($request, $response);
    }

## Creating the response

The `OAuth2\HttpFoundationBridge\Response` object extends `Symfony\Component\HttpFoundation\JsonResponse`,
and implements the `OAuth2_ResponseInterface`, allowing you to pass this in and return it from your controllers.
In Symfony and Silex, this will be all that is needed to integrate the server:

    use OAuth2\HttpFoundationBridge\Response as BridgeResponse;

    // in your controller layer, the $request object is passed in
    public function execute(Request $request)
    {
        //... (instantiate server/response objects)
        $response = new BridgeResponse();
        return $server->handleTokenRequest($request, $response);
    }

> Note: this object will return JSON.  Implement your own class using `OAuth2_ResponseInterface` to support
> a different content-type.

Contact
-------

Please contact Brent Shaffer (bshafs <at> gmail <dot> com) for more information
