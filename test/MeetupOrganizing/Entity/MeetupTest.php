<?php

declare(strict_types=1);

namespace MeetupOrganizing\Domain\Entity;

use InvalidArgumentException;
use MeetupOrganizing\Domain\Meetup\Meetup;
use MeetupOrganizing\Domain\Meetup\MeetupId;
use MeetupOrganizing\Domain\ScheduledDate;
use MeetupOrganizing\Domain\User\UserId;
use PHPUnit\Framework\TestCase;

class MeetupTest extends TestCase
{
    /**
     * @dataProvider provideInvalidParameters
     *
     * @param string $name
     * @param string $description
     */
    public function testMeetupParametersAreValidated(string $name, string $description): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Meetup(
            MeetupId::fromInt(1235),
            UserId::fromInt(3451),
            $name,
            $description,
            ScheduledDate::fromDateTime(new \DateTimeImmutable()),
            false
        );
    }

    public function provideInvalidParameters(): array
    {
        return [
            'Name cannot be empty'        => [
                '',
                'Description',
            ],
            'Description cannot be empty' => [
                '',
                'Description',
            ],
        ];
    }
}
