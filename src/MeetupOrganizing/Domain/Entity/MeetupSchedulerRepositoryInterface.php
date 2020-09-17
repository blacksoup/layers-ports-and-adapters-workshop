<?php

namespace MeetupOrganizing\Domain\Entity;

interface MeetupSchedulerRepositoryInterface
{
    public function save(Meetup $meetup): MeetupId;
}
