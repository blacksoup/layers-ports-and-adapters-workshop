<?php

namespace MeetupOrganizing\Application;

use MeetupOrganizing\Domain\Rsvp;

interface RsvpSubmissionInterface
{
    public function save(Rsvp $rsvp): void;
}
