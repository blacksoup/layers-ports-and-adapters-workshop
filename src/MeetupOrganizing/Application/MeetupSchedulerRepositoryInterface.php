<?php

namespace MeetupOrganizing\Application;

use MeetupOrganizing\Domain\Meetup\Meetup;
use MeetupOrganizing\Domain\Meetup\MeetupId;

interface MeetupSchedulerRepositoryInterface
{
    public function save(Meetup $meetup): MeetupId;
}
