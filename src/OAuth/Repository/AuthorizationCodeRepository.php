<?php

declare(strict_types = 1);

namespace ShieldSSO\OAuth\Repository;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use ShieldSSO\Contract\Repository\AuthorizationCodeRepositoryInterface as AppAuthorizationCodeRepositoryInterface;
use ShieldSSO\OAuth\Entity\AuthorizationCode;

class AuthorizationCodeRepository implements AuthCodeRepositoryInterface
{
    /** @var AppAuthorizationCodeRepositoryInterface */
    private $appAuthorizationCodeRepository;

    public function __construct(AppAuthorizationCodeRepositoryInterface $appAuthorizationCodeRepository)
    {
        $this->appAuthorizationCodeRepository = $appAuthorizationCodeRepository;
    }

    /**
     * @inheritdoc
     */
    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthorizationCode;
    }

    /**
     * @inheritdoc
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authorizationCodeEntity): void
    {
    }

    /**
     * @inheritdoc
     */
    public function revokeAuthCode($code): void
    {
        $authorizationCode = $this->appAuthorizationCodeRepository->getByCode($code);
        $authorizationCode->setRevoked(true);

        $this->appAuthorizationCodeRepository->persist($authorizationCode);
        $this->appAuthorizationCodeRepository->flush();
    }

    /**
     * @inheritdoc
     */
    public function isAuthCodeRevoked($code): bool
    {
        $authorizationCode = $this->appAuthorizationCodeRepository->getByCode($code);

        return $authorizationCode->isRevoked();
    }
}
