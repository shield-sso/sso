<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Contract\Repository\ClientRepositoryInterface;
use ShieldSSO\Entity\Client;

class ClientRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['repository.client'] = function (Container $container): ClientRepositoryInterface {
            /** @var EntityManagerInterface $entityManager */
            /** @var ClientRepositoryInterface $repository */

            $entityManager = $container['orm.em'];
            $repository = $entityManager->getRepository(Client::class);

            return $repository;
        };
    }
}
