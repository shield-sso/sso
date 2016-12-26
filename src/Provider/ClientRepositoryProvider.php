<?php

declare(strict_types = 1);

namespace ShieldSSO\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ClientRepositoryProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $container)
    {
        $container['service'] = function ($container) {
            return $container;
        };
    }
}
