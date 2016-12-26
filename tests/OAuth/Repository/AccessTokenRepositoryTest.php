<?php

declare(strict_types = 1);

namespace ShieldSSO\Test\OAuth\Repository;

use DateTime;
use ShieldSSO\Contract\Repository\AccessTokenRepositoryInterface;
use ShieldSSO\Contract\Repository\ClientRepositoryInterface;
use ShieldSSO\Contract\Repository\ScopeRepositoryInterface;
use ShieldSSO\Contract\Repository\UserRepositoryInterface;
use ShieldSSO\Entity\AccessToken;
use ShieldSSO\Entity\Client;
use ShieldSSO\Entity\Scope;
use ShieldSSO\Entity\User;
use ShieldSSO\OAuth\Entity\AccessToken as OAuthAccessToken;
use ShieldSSO\OAuth\Entity\Client as OAuthClient;
use ShieldSSO\OAuth\Entity\Scope as OAuthScope;
use ShieldSSO\OAuth\Repository\AccessTokenRepository as OAuthAccessTokenRepository;
use ShieldSSO\Test\AbstractRepositoryTest;

class AccessTokenRepositoryTest extends AbstractRepositoryTest
{
    public function testPersistNewAccessToken(): void
    {
        $scopeA = new Scope;
        $scopeA->setName('A');

        $scopeB = new Scope;
        $scopeB->setName('B');

        /** @var ScopeRepositoryInterface $scopeRepository */
        $scopeRepository = parent::$entityManager->getRepository(Scope::class);
        $scopeRepository->persist($scopeA);
        $scopeRepository->persist($scopeB);
        $scopeRepository->flush();

        $this->assertEquals(1, $scopeA->getId());
        $this->assertEquals(2, $scopeB->getId());

        $client = new Client;
        $client->setName('Client');
        $client->setSecret(password_hash('secret', PASSWORD_BCRYPT, ['cost' => 12]));
        $client->setRedirectUri('http://client-a.local/oauth');

        /** @var ClientRepositoryInterface $clientRepository */
        $clientRepository = parent::$entityManager->getRepository(Client::class);
        $clientRepository->persist($client);
        $clientRepository->flush();

        $this->assertEquals(1, $client->getId());

        $user = new User;
        $user->setLogin('User');
        $user->setPassword(password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]));

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = parent::$entityManager->getRepository(User::class);
        $userRepository->persist($user);
        $userRepository->flush();

        $this->assertEquals(1, $user->getId());

        /** @var AccessTokenRepositoryInterface $accessTokenRepository */
        $accessTokenRepository = parent::$entityManager->getRepository(AccessToken::class);

        $oauthAccessTokenRepository = new OAuthAccessTokenRepository(
            $accessTokenRepository,
            $clientRepository,
            $userRepository,
            $scopeRepository
        );

        $oauthClient = new OAuthClient;
        $oauthClient->setName($client->getName());
        $oauthClient->setRedirectUri($client->getRedirectUri());

        $oauthScopeA = new OAuthScope;
        $oauthScopeA->setName($scopeA->getName());
        $oauthScopeB = new OAuthScope;
        $oauthScopeB->setName($scopeB->getName());

        $oauthAccessToken = new OAuthAccessToken;
        $oauthAccessToken->setCode(bin2hex(random_bytes(40)));
        $oauthAccessToken->setExpiryDateTime(new DateTime);
        $oauthAccessToken->setUserIdentifier($user->getLogin());
        $oauthAccessToken->setClient($oauthClient);
        $oauthAccessToken->addScope($oauthScopeA);
        $oauthAccessToken->addScope($oauthScopeB);

        $oauthAccessTokenRepository->persistNewAccessToken($oauthAccessToken);

        $accessToken = $accessTokenRepository->getById(1);
        $this->assertEquals($client->getName(), $accessToken->getClient()->getName());
    }
}
