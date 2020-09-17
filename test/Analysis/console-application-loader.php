<?php
declare(strict_types=1);

use MeetupOrganizing\Infrastructure\Command\ConsoleApplication;
use MeetupOrganizing\Infrastructure\ServiceContainer;

return new ConsoleApplication(
    new ServiceContainer(__DIR__ . '/..')
);
