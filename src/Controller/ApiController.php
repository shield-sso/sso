<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController
{
    /**
     * @param Application $app
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function dataAction(Application $app, Request $request): JsonResponse
    {
        $user = $request->attributes->get('user');

        return $app->json(
            [
                'id' => $user->getId(),
                'login' => $user->getLogin()
            ]
        );
    }
}
