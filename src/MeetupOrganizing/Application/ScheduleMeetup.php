<?php

declare(strict_types=1);

namespace MeetupOrganizing\Application;

class ScheduleMeetup
{
    private int    $organizerId;

    private string $name;

    private string $description;

    private string $scheduledFor;

    public function __construct(int $organizerId, string $name, string $description, string $scheduledFor)
    {
        $this->organizerId  = $organizerId;
        $this->name         = $name;
        $this->description  = $description;
        $this->scheduledFor = $scheduledFor;
    }

    public function organizerId(): int
    {
        return $this->organizerId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function scheduledFor(): string
    {
        return $this->scheduledFor;
    }
}
