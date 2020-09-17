<?php

declare(strict_types=1);

namespace MeetupOrganizing\Application;

use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupId;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;

class MeetupService
{
    /**
     * @var MeetupRepository
     */
    private MeetupRepository $repository;

    public function __construct(MeetupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(
        int $organizerId,
        string $name,
        string $description,
        string $scheduledFor
    ): MeetupId {
        $scheduledate = ScheduledDate::fromString($scheduledFor);

        return $this->repository->save(
            Meetup::create(
                UserId::fromInt($organizerId),
                $name,
                $description,
                $scheduledate
            )
        );
    }
}
