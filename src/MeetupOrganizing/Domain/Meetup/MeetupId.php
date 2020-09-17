<?php

declare(strict_types=1);

namespace MeetupOrganizing\Domain\Meetup;

use Assert\Assert;

final class MeetupId
{
    private int $id;

    private function __construct(int $id)
    {
        Assert::that($id)->greaterThan(0);
        $this->id = $id;
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function asInt(): int
    {
        return $this->id;
    }
}
