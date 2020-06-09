<?php

declare(strict_types=1);

namespace TaskForce\Entity;


use Exception;
use TaskForce\Exception\NotValidActionException;
use TaskForce\Exception\NotValidUserException;

class Task
{
    /**
     * Statuses
     */
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_WORK = 'in_work';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    /**
     * Entity params
     */
    private int $clientId;
    private int $executorId;
    private string $status;


    public function __construct(int $clientId, int $executorId)
    {
        if ($clientId <= 0 || $executorId <=0){
            throw new NotValidUserException('Not valid user id, cant create new Task');
        }

        $this->clientId = $clientId;
        $this->executorId = $executorId;
        $this->status = self::STATUS_NEW;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getExecutorId(): int
    {
        return $this->executorId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param Action $action
     * @param int $currentUserId
     * @return string|null
     */
    public function perform(Action $action, int $currentUserId): ?string
    {
        if (!$this->isValidAction($action)){
            throw new NotValidActionException('Not valid action, cant perform an Action!');
        }

        if ($currentUserId <= 0){
            throw new NotValidUserException('Not valid user id, cant perform an Action!');
        }

        $availableActions = $this->getAvailableActions($this->status, $currentUserId);

        foreach ($availableActions as $possibleAction) {
            if ($possibleAction == $action) {
                $nextStatus = $this->getNextStatus($action);
                if ($nextStatus) {
                    $this->status = $nextStatus;
                    return $nextStatus;
                }
            }
        }

        return null;
    }

    public function getAvailableActions(string $status, int $currentUserId): array
    {
        if (!$this->isValidStatus($status)){
            throw new NotValidUserException('Not valid status, cant get Available actions!');
        }

        if ($currentUserId <= 0){
            throw new NotValidUserException('Not valid user id, cant get Available actions!');
        }

        $actions = [];

        if ($status === self::STATUS_NEW) {
            $actions = [new AnswerAction(), new CancelAction()];
        }

        if ($status === self::STATUS_IN_WORK) {
            $actions = [new CompleteAction(), new RefuseAction()];
        }

        $resultActions = [];

        foreach ($actions as $action) {
            if ($action->checkAccess($this->executorId, $this->clientId, $currentUserId)) {
                $resultActions[] = $action;
            }
        }

        return $resultActions;
    }

    /**
     * @param $action
     * @return string|null
     */
    public function getNextStatus(Action $action): ?string
    {
        if (!$this->isValidAction($action)){
            throw new NotValidActionException('Not valid action, cant get next Status!');
        }

        if (!$this->status || !$action) {
            return null;
        }

        if ($this->status === self::STATUS_NEW) {
            if ($action instanceof AnswerAction) {
                return self::STATUS_IN_WORK;
            }
            if ($action instanceof CancelAction) {
                return self::STATUS_CANCELED;
            }
        }

        if ($this->status === self::STATUS_IN_WORK) {
            if ($action instanceof CompleteAction) {
                return self::STATUS_DONE;
            }
            if ($action instanceof RefuseAction) {
                return self::STATUS_FAILED;
            }
        }

        return null;
    }

    private function isValidStatus(string $status): bool
    {
        return in_array($status, [
            self::STATUS_NEW,
            self::STATUS_FAILED,
            self::STATUS_DONE,
            self::STATUS_IN_WORK,
            self::STATUS_CANCELED
        ], true);
    }

    private function isValidAction(Action $action): bool
    {
        return in_array($action, [
            new RefuseAction(),
            new CompleteAction(),
            new CancelAction(),
            new AnswerAction(),
        ], false);
    }
}
