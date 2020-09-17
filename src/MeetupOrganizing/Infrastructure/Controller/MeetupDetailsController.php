<?php
declare(strict_types=1);

namespace MeetupOrganizing\Infrastructure\Controller;

use Assert\Assert;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use MeetupOrganizing\Application\RsvpRepositoryDetailInterface;
use MeetupOrganizing\Domain\Rsvp;
use MeetupOrganizing\Application\UserRepositoryInterface;
use MeetupOrganizing\Domain\User\UserId;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Zend\Expressive\Template\TemplateRendererInterface;

final class MeetupDetailsController
{
    private Connection $connection;

    private UserRepositoryInterface $userRepository;

    private TemplateRendererInterface $renderer;

    private RsvpRepositoryDetailInterface $rsvpRepository;

    public function __construct(
        Connection $connection,
        UserRepositoryInterface $userRepository,
        RsvpRepositoryDetailInterface $rsvpRepository,
        TemplateRendererInterface $renderer
    ) {
        $this->connection = $connection;
        $this->renderer = $renderer;
        $this->userRepository = $userRepository;
        $this->rsvpRepository = $rsvpRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out = null
    ): ResponseInterface {

        $statement = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('meetups')
            ->where('meetupId = :meetupId')
            ->setParameter('meetupId', (int)$request->getAttribute('id'))
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        $meetup = $statement->fetch(PDO::FETCH_ASSOC);

        if ($meetup === false) {
            throw new RuntimeException('Meetup not found');
        }

        $organizer = $this->userRepository->getById(UserId::fromInt((int)$meetup['organizerId']));
        $rsvps = $this->rsvpRepository->getByMeetupId((int)$meetup['meetupId']);
        $users = array_map(
            function (Rsvp $rsvp) {
                return $this->userRepository->getById($rsvp->userId());
            },
            $rsvps
        );

        $response->getBody()->write(
            $this->renderer->render(
                'meetup-details.html.twig',
                [
                    'meetup' => $meetup,
                    'organizer' => $organizer,
                    'attendees' => $users
                ]));

        return $response;
    }
}
