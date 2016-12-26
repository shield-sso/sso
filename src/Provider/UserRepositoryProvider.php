<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Entity\User;
use ShieldSSO\Contract\Repository\UserRepositoryInterface;

class UserRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['repository.user'] = function (Container $container): UserRepositoryInterface {
            /** @var EntityManagerInterface $entityManager */
            /** @var UserRepositoryInterface $repository */

            $entityManager = $container['orm.em'];
            $repository = $entityManager->getRepository(User::class);

            return $repository;
        };
    }
}
