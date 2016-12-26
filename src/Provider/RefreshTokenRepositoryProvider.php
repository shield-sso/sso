<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Contract\Repository\RefreshTokenRepositoryInterface;
use ShieldSSO\Entity\RefreshToken;

class RefreshTokenRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['repository.refresh_token'] = function (Container $container): RefreshTokenRepositoryInterface {
            /** @var EntityManagerInterface $entityManager */
            /** @var RefreshTokenRepositoryInterface $repository */

            $entityManager = $container['orm.em'];
            $repository = $entityManager->getRepository(RefreshToken::class);

            return $repository;
        };
    }
}
