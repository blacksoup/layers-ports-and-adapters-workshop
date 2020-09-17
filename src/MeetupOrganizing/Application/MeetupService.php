<?php

declare(strict_types=1);

namespace MeetupOrganizing\Application;

use InvalidArgumentException;
use MeetupOrganizing\Domain\Clock;
use MeetupOrganizing\Domain\Entity\Meetup;
use MeetupOrganizing\Domain\Entity\MeetupId;
use MeetupOrganizing\Domain\Entity\MeetupSchedulerRepositoryInterface;
use MeetupOrganizing\Domain\Entity\UserRepositoryInterface;
use MeetupOrganizing\Domain\Entity\ScheduledDate;
use MeetupOrganizing\Domain\Entity\UserId;

class MeetupService
{
    /**
     * @var MeetupSchedulerRepositoryInterface
     */
    private MeetupSchedulerRepositoryInterface $repository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var Clock
     */
    private Clock $clock;

    public function __construct(
        UserRepositoryInterface $userRepository,
        MeetupSchedulerRepositoryInterface $meetupRepository,
        Clock $clock
    ) {
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
