<?php

namespace OAuth2\HttpFoundation;

use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
 class Server implements \OAuth2_Controller_AccessControllerInterface,
    \OAuth2_Controller_AuthorizeControllerInterface, \OAuth2_Controller_GrantControllerInterface
 {
    private $server;

    public function __construct(\OAuth2_Server $server)
    {

    }
 }
