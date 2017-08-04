<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use ShieldSSO\Repository\UserRepository;
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
        /** @var UserRepository $userRepository */
        $userRepository = $app['repository.user'];

        trigger_error($request->attributes->get('oauth_user_id'));

        $user = $userRepository->getById((int) $request->attributes->get('oauth_user_id'));

        return $app->json(
            [
                'id' => $user->getId(),
                'login' => $user->getLogin()
            ]
        );
    }
}
