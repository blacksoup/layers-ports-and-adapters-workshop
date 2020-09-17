<?php

declare(strict_types=1);

namespace MeetupOrganizing\Infrastructure\Controller;

use MeetupOrganizing\Domain\Clock;
use MeetupOrganizing\Application\ListMeetupsRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ListMeetupsController implements MiddlewareInterface
{
    private ListMeetupsRepositoryInterface $listMeetupsRepository;

    private TemplateRendererInterface      $renderer;

    private Clock $clock;

    public function __construct(
        ListMeetupsRepositoryInterface $listMeetupsRepository,
        TemplateRendererInterface $renderer,
        Clock $clock
    ) {
        $this->renderer              = $renderer;
        $this->listMeetupsRepository = $listMeetupsRepository;
        $this->clock = $clock;
    }

    public function __invoke(Request $request, Response $response, callable $out = null): ResponseInterface
    {
        $upcomingMeetups = $this->listMeetupsRepository->listUpcomingMeetups($this->clock);
        $pastMeetups     = $this->listMeetupsRepository->listPastMeetups($this->clock);

        $response->getBody()->write(
            $this->renderer->render(
                'list-meetups.html.twig',
                [
                    'upcomingMeetups' => $upcomingMeetups,
                    'pastMeetups'     => $pastMeetups,
                ]
            )
        );

        return $response;
    }
}
