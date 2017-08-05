<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Contract\Repository\AccessTokenRepositoryInterface;
use ShieldSSO\Entity\AccessToken;

class AccessTokenRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['repository.access_token'] = function (Container $container): AccessTokenRepositoryInterface {
            /** @var EntityManagerInterface $entityManager */
            /** @var AccessTokenRepositoryInterface $repository */

            $entityManager = $container['orm.em'];
            $repository = $entityManager->getRepository(AccessToken::class);

            return $repository;
        };
    }
}
