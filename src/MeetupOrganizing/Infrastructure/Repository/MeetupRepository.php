<?php

declare(strict_types=1);

namespace MeetupOrganizing\Infrastructure\Repository;

use Assert\Assert;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use MeetupOrganizing\Application\ListMeetupsRepositoryInterface;
use MeetupOrganizing\Domain\Clock;
use MeetupOrganizing\Domain\Meetup\Meetup;
use MeetupOrganizing\Domain\Meetup\MeetupForList;
use MeetupOrganizing\Domain\Meetup\MeetupId;
use MeetupOrganizing\Application\MeetupSchedulerRepositoryInterface;
use MeetupOrganizing\Domain\ScheduledDate;
use PDO;

final class MeetupRepository implements ListMeetupsRepositoryInterface, MeetupSchedulerRepositoryInterface
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

    public function listUpcomingMeetups(Clock $clock): array
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetups')
            ->where('scheduledFor >= :now')
            ->setParameter('now', $clock->currentTime()->format(ScheduledDate::DATE_TIME_FORMAT))
            ->andWhere('wasCancelled = :wasNotCancelled')
            ->setParameter('wasNotCancelled', 0)
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            static function (array $record) {
                return MeetupForList::fromRecord($record);
            },
            $records
        );
    }

    public function listPastMeetups(Clock $clock): array
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('meetups')
            ->where('scheduledFor < :now')
            ->setParameter('now', $clock->currentTime()->format(ScheduledDate::DATE_TIME_FORMAT))
            ->andWhere('wasCancelled = :wasNotCancelled')
            ->setParameter('wasNotCancelled', 0)
            ->execute();
        Assert::that($statement)->isInstanceOf(Statement::class);

        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            static function (array $record) {
                return MeetupForList::fromRecord($record);
            },
            $records
        );
    }
}
