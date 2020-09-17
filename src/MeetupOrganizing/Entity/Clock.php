<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use DateTimeImmutable;

class Clock
{
    public function currentTime(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
