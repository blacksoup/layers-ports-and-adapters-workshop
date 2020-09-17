<?php

declare(strict_types=1);

namespace MeetupOrganizing\Domain\Meetup;

use Assert\Assert;
use MeetupOrganizing\Domain\ScheduledDate;
use MeetupOrganizing\Domain\User\UserId;

class Meetup
{
    private ?MeetupId     $meetupId;

    private UserId        $organizerId;

    private string        $name;

    private string        $description;

    private ScheduledDate $scheduledFor;

    private bool          $wasCancelled;

    public function __construct(
        ?MeetupId $meetupId,
        UserId $organizerId,
        string $name,
        string $description,
        ScheduledDate $scheduledFor,
        bool $wasCancelled = false
    ) {
        $this->meetupId    = $meetupId;
        $this->organizerId = $organizerId;

        Assert::that($name)->notEmpty();
        $this->name = $name;

        Assert::that($description)->notEmpty();
        $this->description  = $description;
        $this->scheduledFor = $scheduledFor;

        $this->wasCancelled = $wasCancelled;
    }

    public static function create(
        UserId $organizerId,
        string $name,
        string $description,
        ScheduledDate $scheduledFor
    ): Meetup {
        return new self(null, $organizerId, $name, $description, $scheduledFor);
    }

    public function getData(): array
    {
        $meetupId = null === $this->meetupId
            ? null
            : $this->meetupId->asInt();

        return [
            'meetupId'     => $meetupId,
            'organizerId'  => $this->organizerId->asInt(),
            'name'         => $this->name,
            'description'  => $this->description,
            'scheduledFor' => $this->scheduledFor->asString(),
            'wasCancelled' => (int)$this->wasCancelled,
        ];
    }
}
