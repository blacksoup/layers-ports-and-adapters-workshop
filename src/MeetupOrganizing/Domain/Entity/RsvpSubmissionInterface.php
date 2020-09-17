<?php

namespace MeetupOrganizing\Domain\Entity;

interface RsvpSubmissionInterface
{
    public function save(Rsvp $rsvp): void;
}
