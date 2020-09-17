<?php

namespace MeetupOrganizing\Domain\Entity;

interface UserRepositoryInterface
{
    public function getById(UserId $id): User;

    /**
     * @return array<User> & User[]
     */
    public function findAll(): array;

    public function getOrganizerId(): UserId;
}
