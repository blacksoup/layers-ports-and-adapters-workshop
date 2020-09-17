<?php

declare(strict_types=1);

namespace MeetupOrganizing\Application;

use DateTimeImmutable;
use InvalidArgumentException;
use MeetupOrganizing\Entity\Meetup;
use MeetupOrganizing\Entity\MeetupId;
use MeetupOrganizing\Entity\MeetupRepository;
use MeetupOrganizing\Entity\ScheduledDate;
use MeetupOrganizing\Entity\UserId;
use MeetupOrganizing\Entity\UserRepository;

class MeetupService
{
    /**
     * @var MeetupRepository
     */
    private MeetupRepository $repository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, MeetupRepository $meetupRepository)
    {
        $this->userRepository = $userRepository;
        $this->repository     = $meetupRepository;
    }

    public function scheduleMeetup(ScheduleMeetup $command): MeetupId
    {
        $scheduledate = ScheduledDate::fromString($command->scheduledFor());

        if (!$scheduledate->isInTheFuture(new DateTimeImmutable())) {
            throw new InvalidArgumentException('Schedule date cannot be in the past: ' . $scheduledate->asString());
        }

        $user = $this->userRepository->getById(UserId::fromInt($command->organizerId()));

        return $this->repository->save(
            Meetup::create(
                $user->userId(),
                $command->name(),
                $command->description(),
                $scheduledate
            )
        );
    }
}
