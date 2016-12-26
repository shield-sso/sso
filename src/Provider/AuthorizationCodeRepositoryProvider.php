<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Contract\Repository\AuthorizationCodeRepositoryInterface;
use ShieldSSO\Entity\AuthorizationCode;

class AuthorizationCodeRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['repository.authorization_code'] = function (Container $container): AuthorizationCodeRepositoryInterface {
            /** @var EntityManagerInterface $entityManager */
            /** @var AuthorizationCodeRepositoryInterface $repository */

            $entityManager = $container['orm.em'];
            $repository = $entityManager->getRepository(AuthorizationCode::class);

            return $repository;
        };
    }
}
