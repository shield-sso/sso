<?php

declare(strict_types = 1);

namespace ShieldSSO\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ShieldSSO\Entity\Scope;

class ScopeFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $scope = new Scope();
        $scope->setName('basic');

        $manager->persist($scope);
        $manager->flush();
    }
}
