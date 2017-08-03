<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController
{
    /**
     * @param Application $app
     *
     * @return JsonResponse
     */
    public function dataAction(Application $app): JsonResponse
    {
        return $app->json('teste');
    }
}
