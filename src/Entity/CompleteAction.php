<?php


namespace TaskForce\Entity;


class CompleteAction extends Action
{

    public function getName(): string
    {
        return 'Завершить';
    }

    public function getCode(): string
    {
        return 'action_complete';
    }

    public function checkAccess(int $executorId, int $clientId, int $currentUserId): bool
    {
        return $currentUserId === $clientId;
    }
}
