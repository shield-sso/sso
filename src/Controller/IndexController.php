<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    /**
     * @param Application $app
     *
     * @return Response
     */
    public function indexAction(Application $app): Response
    {
        return $app->render('index.html.twig');
    }

    /**
     * @param Application $app
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Application $app, Request $request): Response
    {
        return $app->render('login.html.twig', [
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
        ]);
    }
}
