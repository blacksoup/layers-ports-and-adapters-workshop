<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Assert\Assert;
use LogicException;

class MeetupForList
{
    /**
     * @var array
     */
    private array $meetupData;

    private function __construct(int $meetupId, string $name, string $description, string $scheduledFor)
    {
        $this->meetupData = [
            'meetupId'     => $meetupId,
            'name'         => $name,
            'description'  => $description,
            'scheduledFor' => $scheduledFor,
        ];
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
     * @param mixed $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->meetupData[$name] ?? null;
    }

    /**
     * @param mixed $name
     * @param mixed $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        throw new LogicException('Trying to write property of read only object ' . self::class);
    }
}
