<?php

declare(strict_types=1);

namespace MeetupOrganizing\Infrastructure\Controller;

use Assert\Assert;
use MeetupOrganizing\Domain\User\UserId;
use MeetupOrganizing\Application\UserRepositoryInterface;
use RuntimeException;
use MeetupOrganizing\Infrastructure\Repository\UserRepository;
use MeetupOrganizing\Infrastructure\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

final class SwitchUserController
{
    private UserRepositoryInterface $userRepository;

    private Session                 $session;

    public function __construct(
        UserRepositoryInterface $userRepository,
        Session $session
    ) {
        $this->session        = $session;
        $this->userRepository = $userRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $postData = $request->getParsedBody();
        Assert::that($postData)->isArray();

        if (!isset($postData['userId'])) {
            throw new RuntimeException('Bad request');
        }

        $user = $this->userRepository->getById(
            UserId::fromInt((int)$postData['userId'])
        );
        $this->session->setLoggedInUserId($user->userId());

        return new RedirectResponse('/');
    }
}
