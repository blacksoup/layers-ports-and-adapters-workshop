<?php

declare(strict_types=1);

namespace MeetupOrganizing\Entity;

use Doctrine\DBAL\Connection;

final class MeetupRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Meetup $meetup): MeetupId
    {
        $this->connection->insert('meetups', $meetup->getData());

        return MeetupId::fromInt((int)$this->connection->lastInsertId());
    }
}
