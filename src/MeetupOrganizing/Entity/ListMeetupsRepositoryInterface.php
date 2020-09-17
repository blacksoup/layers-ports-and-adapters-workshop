<?php

namespace MeetupOrganizing\Entity;

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
