<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use ShieldSSO\Application;
use ShieldSSO\Entity\Client;
use ShieldSSO\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;

class OAuthController
{
    /**
     * @param Application $app
     *
     * @return JsonResponse
     */
    public function authorizeAction(Application $app): JsonResponse
    {
        /** @var EntityManager $entityManager */
        /** @var ClientRepository $repository */
        /** @var Client $client */

        $entityManager = $app['orm.em'];
        $repository = $entityManager->getRepository(Client::class);
        $client = $repository->find(1);

        if ($client == null) {
            $client = new Client;
            $client->setName('a');
            $client->setRedirectUri('http://client-a.local/oauth');

            $repository->persist($client);
            $repository->flush();
        }

        return new JsonResponse(
            [
                'authorization_code' => 'code',
                'client' => $client->getName()
            ]
        );
    }
}
