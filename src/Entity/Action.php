<?php


namespace TaskForce\Entity;


abstract class Action
{
    abstract public function getName(): string;

    abstract public function getCode(): string;

    abstract public function checkAccess(int $executorId, int $clientId, int $currentUserId): bool;
}
