<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use ShieldSSO\Entity\Client;
use ShieldSSO\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class OAuthController
{
    /**
     * @param Application $app
     *
     * @return Response
     */
    public function authorizeAction(Application $app)
    {
        /** @var EntityManager $entityManager */
        /** @var ClientRepository $repository */
        /** @var Client $client */

        $entityManager = $app['orm.em'];
        $repository = $entityManager->getRepository(Client::class);
        $client = $repository->find(1);

        return new JsonResponse(
            [
                'authorization_code' => 'code',
                'client' => $client->getName()
            ]
        );
    }
}
