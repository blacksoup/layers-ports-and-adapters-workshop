<?php

declare(strict_types=1);

namespace MeetupOrganizing\Application;

use InvalidArgumentException;
use MeetupOrganizing\Domain\Clock;
use MeetupOrganizing\Domain\Meetup\Meetup;
use MeetupOrganizing\Domain\Meetup\MeetupId;
use MeetupOrganizing\Domain\ScheduledDate;
use MeetupOrganizing\Domain\User\UserId;

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
