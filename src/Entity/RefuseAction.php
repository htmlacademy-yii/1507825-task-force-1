<?php

declare(strict_types=1);

namespace TaskForce\Entity;


class RefuseAction extends Action
{

    public function getName(): string
    {
        return 'Отказаться';
    }

    public function getCode(): string
    {
        return 'action_refuse';
    }

    public function checkAccess(int $executorId, int $clientId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
