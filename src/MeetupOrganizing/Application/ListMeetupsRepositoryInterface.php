<?php

namespace MeetupOrganizing\Application;

use MeetupOrganizing\Domain\Clock;
use MeetupOrganizing\Domain\Meetup\MeetupForList;

interface ListMeetupsRepositoryInterface
{
    /**
     * @param Clock $clock
     *
     * @return array<MeetupForList> & MeetupForList[]
     */
    public function listUpcomingMeetups(Clock $clock): array;

    /**
     * @param Clock $clock
     *
     * @return array<MeetupForList> & MeetupForList[]
     */
    public function listPastMeetups(Clock $clock): array;
}
