<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use ShieldSSO\Contract\Repository\ScopeRepositoryInterface;
use ShieldSSO\Entity\Scope;

class ScopeRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['repository.scope'] = function (Container $container): ScopeRepositoryInterface {
            /** @var EntityManagerInterface $entityManager */
            /** @var ScopeRepositoryInterface $repository */

            $entityManager = $container['orm.em'];
            $repository = $entityManager->getRepository(Scope::class);

            return $repository;
        };
    }
}
