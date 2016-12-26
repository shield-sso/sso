<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class OAuthController
{
    /**
     * @param Application $app
     *
     * @return JsonResponse
     */
    public function authorizeAction(Application $app): JsonResponse
    {
        return $app->json(['authorization_code' => 'code']);
    }
}
