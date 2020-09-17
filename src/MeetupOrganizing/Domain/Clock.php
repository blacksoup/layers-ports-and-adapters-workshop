<?php

declare(strict_types=1);

namespace MeetupOrganizing\Domain;

use DateTimeImmutable;

class Clock
{
    public function currentTime(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
