oauth2-server-httpfoundation-bridge
===================================

A bridge to HttpFoundation for oauth2-server-php.

oauth2-server-httpfoundation-bridge is a wrapper for [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php)
which returns HttpFoundation\Response instead of OAuth2_Response, and returns HttpFoundation\Request instead of OAuth2_Request
If you are integrating oauth2 into a twig or symfony app, this will make your application much cleaner

## Creating the Server

Creating the server is no different from before, except that you use the `OAuth2\HttpFoundationBridge\Server`
class instead of OAuth2_Server:

    $server = new OAuth2\HttpFoundationBridge\Server($app['oauth_storage']);
    $server->addGrantType(new OAuth2_GrantType_AuthorizationCode($app['oauth_storage']));
    ...

## Creating the request

Creating the response object is the same as before, except now you use the
`OAuth2\HttpFoundationBridge\Request` class:

    $request = OAuth2\HttpFoundationBridge\Request::createFromGlobals();
    $app->run($request);

If the HttpFoundation request already exists, you can use the static `createFromRequest`
function to build the OAuth2\HttpFoundationBridge\Request instance:

    $request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
    $bridgeRequest = OAuth2\HttpFoundationBridge\Request::createFromRequest($request);

Contact
-------

Please contact Brent Shaffer (bshafs <at> gmail <dot> com) for more information