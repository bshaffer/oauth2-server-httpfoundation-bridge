oauth2-server-httpfoundation-bridge
===================================

A bridge to HttpFoundation for oauth2-server-php.

oauth2-server-httpfoundation-bridge is a wrapper for [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php)
which returns HttpFoundation\Response instead of OAuth2_Response, and uses HttpFoundation\Request instead of OAuth2_Request.
If you are integrating oauth2 into a silex or symfony app, (or any app using HttpFoundation), this will make your
application much cleaner

## Creating the Server

Creating the server is no different from before, except that you use the `OAuth2\HttpFoundationBridge\Server`
class instead of OAuth2_Server:

    $server = new OAuth2\HttpFoundationBridge\Server($app['oauth_storage']);
    $server->addGrantType(new OAuth2_GrantType_AuthorizationCode($app['oauth_storage']));
    ...

Now, when you call any of the `handle*Request` methods, or call `getResponse`, the object returned will be an
instance of `Symfony\Component\HttpFoundation\Response`:

    if (!$token = $server->grantAccessToken($request)) {
        $response = $server->getResponse();
        if ($response->isSuccessful()) {
            // isSuccessful is unique to HttpFoundation
        }
    }

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
        $bridgeRequest = BridgeRequest::createFromRequest($request);
        $server->grantAccessToken($request);
    }


Contact
-------

Please contact Brent Shaffer (bshafs <at> gmail <dot> com) for more information