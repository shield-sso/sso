<?php

declare(strict_types = 1);

namespace ShieldSSO\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ShieldSSO\Entity\User;

class UserFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $pass = getenv('FIXTURE_USER_PASS');
        if (empty($pass)) {
            $pass = 'pass';
        }

        $user->setLogin('daniel.iwaniec92@gmail.com');
        $user->setPassword(password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]));
        $user->setActive(null);

        $manager->persist($user);
        $manager->flush();
    }
}
