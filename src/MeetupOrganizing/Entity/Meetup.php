<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

class Meetup
{
    private ?MeetupId $meetupId;

    private UserId    $organizerId;

    private string    $name;

    private string    $description;

    private string    $scheduledFor;

    private int       $wasCancelled;

    public function __construct(
        ?MeetupId $meetupId,
        UserId $organizerId,
        string $name,
        string $description,
        string $scheduledFor,
        int $wasCancelled = 0
    ) {
        $this->meetupId     = $meetupId;
        $this->organizerId  = $organizerId;
        $this->name         = $name;
        $this->description  = $description;
        $this->scheduledFor = $scheduledFor;
        $this->wasCancelled = $wasCancelled;
    }

    public static function create(
        UserId $organizerId,
        string $name,
        string $description,
        string $scheduledFor
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
            'scheduledFor' => $this->scheduledFor,
            'wasCancelled' => $this->wasCancelled,
        ];
    }
}
