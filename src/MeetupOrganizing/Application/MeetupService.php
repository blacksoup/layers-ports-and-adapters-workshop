<?php

declare(strict_types=1);

namespace MeetupOrganizing\Application;

use InvalidArgumentException;
use MeetupOrganizing\Entity\Clock;
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

    /**
     * @var Clock
     */
    private Clock $clock;

    public function __construct(UserRepository $userRepository, MeetupRepository $meetupRepository, Clock $clock)
    {
        $this->userRepository = $userRepository;
        $this->repository     = $meetupRepository;
        $this->clock          = $clock;
    }

    public function scheduleMeetup(ScheduleMeetup $command): MeetupId
    {
        $scheduledate = ScheduledDate::fromString($command->scheduledFor());

        $currentDateTime = $this->clock->currentTime();
        if (!$scheduledate->isInTheFuture($currentDateTime)) {
            $currentDateTimeString = ScheduledDate::fromDateTime($currentDateTime)->asString();
            throw new InvalidArgumentException(
                "Expected schedule date to be after {$currentDateTimeString}. Got: {$scheduledate->asString()}"
            );
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
