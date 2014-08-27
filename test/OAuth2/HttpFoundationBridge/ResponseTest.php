<?php

namespace OAuth2\HttpFoundationBridge;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideRedirect */
    public function testRedirect($expected, $url, $state = null, $error = null, $error_description = null, $error_uri = null)
    {
        $response = new Response();

        $response->setRedirect(301, $url, $state, $error, $error_description, $error_uri);
        $this->assertEquals($expected, $response->headers->get('Location'));
    }

    public function provideRedirect()
    {
        return array(
            array('http://test.com/path?error=foo', 'http://test.com/path', null, 'foo'),
            array('https://sub.test.com/path?query=string&error=foo', 'https://sub.test.com/path?query=string', null, 'foo'),
            array('http://test.com/path?error=foo&error_description=this+is+a+description', 'http://test.com/path', null, 'foo', 'this is a description'),
            array('http://test.com/path?state=xyz&error=foo&error_description=this+is+a+description', 'http://test.com/path', 'xyz', 'foo', 'this is a description'),
            array('http://test.com/path?state=xyz&error=foo&error_description=this+is+a+description&error_uri=http%3A%2F%2Fbrentertainment.com', 'http://test.com/path', 'xyz', 'foo', 'this is a description', 'http://brentertainment.com'),
        );
    }
}
