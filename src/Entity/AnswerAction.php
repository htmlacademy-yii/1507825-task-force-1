<?php

declare(strict_types=1);

namespace TaskForce\Entity;


class AnswerAction extends Action
{

    public function getName(): string
    {
        return 'Ответить';
    }

    public function getCode(): string
    {
        return 'action_answer';
    }

    public function checkAccess(int $executorId, int $clientId, int $currentUserId): bool
    {
        return $currentUserId === $executorId;
    }
}
