<?php

declare(strict_types=1);

namespace TaskForce\Entity;


class CancelAction extends Action
{

    public function getName(): string
    {
        return 'Отменить';
    }

    public function getCode(): string
    {
        return 'action_cancel';
    }

    public function checkAccess(int $executorId, int $clientId, int $currentUserId): bool
    {
        return $currentUserId === $clientId;
    }
}
