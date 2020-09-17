<?php

declare(strict_types=1);

namespace MeetupOrganizing\Domain\Entity;

use Assert\Assert;

class MeetupForList
{
    private int    $meetupId;

    private string $name;

    private string $description;

    private string $scheduledFor;

    private function __construct(int $meetupId, string $name, string $description, string $scheduledFor)
    {
        $this->meetupId     = $meetupId;
        $this->name         = $name;
        $this->description  = $description;
        $this->scheduledFor = $scheduledFor;
    }

    public static function fromRecord(array $record): MeetupForList
    {
        Assert::lazy()
            ->that($record)->keyExists('meetupId')
            ->that($record)->keyExists('name')
            ->that($record)->keyExists('description')
            ->that($record)->keyExists('scheduledFor');

        return new self(
            (int)$record['meetupId'],
            (string)$record['name'],
            (string)$record['description'],
            (string)$record['scheduledFor']
        );
    }

    /**
     * @return int
     */
    public function meetupId(): int
    {
        return $this->meetupId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function scheduledFor(): string
    {
        return $this->scheduledFor;
    }
}
