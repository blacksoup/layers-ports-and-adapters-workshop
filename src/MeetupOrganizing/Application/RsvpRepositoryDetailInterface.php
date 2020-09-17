<?php

namespace MeetupOrganizing\Application;

use MeetupOrganizing\Domain\Rsvp;

interface RsvpRepositoryDetailInterface
{
    /**
     * @param int $meetupId
     *
     * @return array<Rsvp> & Rsvp[]
     */
    public function getByMeetupId(int $meetupId): array;
}
