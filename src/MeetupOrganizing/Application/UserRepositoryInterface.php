<?php

namespace MeetupOrganizing\Application;

use MeetupOrganizing\Domain\User\User;
use MeetupOrganizing\Domain\User\UserId;

interface UserRepositoryInterface
{
    public function getById(UserId $id): User;

    /**
     * @return array<User> & User[]
     */
    public function findAll(): array;

    public function getOrganizerId(): UserId;
}
