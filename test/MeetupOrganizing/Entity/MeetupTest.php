<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MeetupTest extends TestCase
{
    /**
     * @dataProvider provideInvalidParameters
     *
     * @param string $name
     * @param string $description
     * @param int    $wasCancelled
     */
    public function testMeetupParametersAreValidated(
        string $name,
        string $description,
        int $wasCancelled = 0
    ): void {
        $this->expectException(InvalidArgumentException::class);

        new Meetup(
            MeetupId::fromInt(1235),
            UserId::fromInt(3451),
            $name,
            $description,
            ScheduledDate::fromDateTime(new \DateTimeImmutable()),
            $wasCancelled
        );
    }

    public function provideInvalidParameters(): array
    {
        return [
            'Name cannot be empty'                 => [
                '',
                'Description',
                0,
            ],
            'Description cannot be empty'          => [
                '',
                'Description',
                0,
            ],
            'WasCancelled cannot be lower than 0'  => [
                '',
                'Description',
                -1,
            ],
            'WasCancelled cannot be higher than 1' => [
                '',
                'Description',
                2,
            ],
        ];
    }
}
