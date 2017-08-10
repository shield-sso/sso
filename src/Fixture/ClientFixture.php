<?php

declare(strict_types = 1);

namespace ShieldSSO\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use ShieldSSO\Entity\Client;

class ClientFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $secret = getenv('FIXTURE_CLIENT_GOOGLE_SECRET');
        if (empty($secret)) {
            $secret = 'secret';
        }

        $client = new Client();
        $client->setName('google');
        $client->setSecret(password_hash($secret, PASSWORD_BCRYPT, ['cost' => 12]));
        $client->setRedirectUri('https://developers.google.com/oauthplayground');
        $manager->persist($client);

        $secret = getenv('FIXTURE_CLIENT_A_SECRET');
        if (empty($secret)) {
            $secret = 'secret_a';
        }

        $clientAUrl = getenv('FIXTURE_CLIENT_A_URL');
        if (empty($clientAUrl)) {
            $clientAUrl = 'http://client-a.local';
        }

        $client = new Client();
        $client->setName('client-a');
        $client->setSecret(password_hash($secret, PASSWORD_BCRYPT, ['cost' => 12]));
        $client->setRedirectUri($clientAUrl . '/login/check-sso');
        $manager->persist($client);

        $secret = getenv('FIXTURE_CLIENT_B_SECRET');
        if (empty($secret)) {
            $secret = 'secret_b';
        }

        $clientAUrl = getenv('FIXTURE_CLIENT_B_URL');
        if (empty($clientAUrl)) {
            $clientAUrl = 'http://client-b.local';
        }

        $client = new Client();
        $client->setName('client-b');
        $client->setSecret(password_hash($secret, PASSWORD_BCRYPT, ['cost' => 12]));
        $client->setRedirectUri($clientAUrl . '/login/check-sso');
        $manager->persist($client);

        $manager->flush();
    }
}
