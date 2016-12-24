<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    /**
     * @param Application $app
     *
     * @return Response
     */
    public function indexAction(Application $app)
    {
        return $app->render('index.html.twig');
    }
}
