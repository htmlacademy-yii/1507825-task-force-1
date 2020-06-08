<?php


namespace TaskForce\Entity;


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
     * Actions
     */
    public const ACTION_CANCEL = 'cancel';
    public const ACTION_ANSWER = 'answer';
    public const ACTION_COMPLETE = 'complete';
    public const ACTION_REFUSE = 'refuse';

    /**
     * Entity params
     */
    private int $clientId;
    private int $executorId;
    private string $status;

    public function __construct(int $clientId, int $executorId)
    {
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
     * @param $action
     * @return string|null
     */
    public function perform(string $action): ?string
    {
        $availableActions = $this->getAvailableActions($this->status);
        if ($availableActions && in_array($action, $availableActions, true)){
            $nextStatus = $this->getNextStatus($action);
            if ($nextStatus){
                $this->status = $nextStatus;
                return $nextStatus;
            }
        }

        return null;
    }

    /**
     * @param $action
     * @return string|null
     */
    public function getNextStatus(string $action): ?string
    {

        if (!$this->status || !$action) {
            return null;
        }

        if ($this->status === self::STATUS_NEW){
            if ($action === self::ACTION_ANSWER) {
                return self::STATUS_IN_WORK;
            }
            if ($action === self::ACTION_CANCEL) {
                return self::STATUS_CANCELED;
            }
        }

        if ($this->status === self::STATUS_IN_WORK){
            if ($action === self::ACTION_COMPLETE) {
                return self::STATUS_DONE;
            }
            if ($action === self::ACTION_REFUSE) {
                return self::STATUS_FAILED;
            }
        }

        return null;
    }

    public function getAvailableActions(string $status, int $currentUserId): array
    {
        $actions = [];

        if ($status === self::STATUS_NEW){
            $actions = [new AnswerAction(), new CancelAction()];
        }

        if ($status === self::STATUS_IN_WORK){
            $actions = [new CompleteAction(), new RefuseAction()];
        }

        $resultActions = [];

        foreach ($actions as $action){
            if ($action->checkAccess($this->executorId, $this->clientId, $currentUserId)){
                $resultActions[] = $action;
            }
        }

        return $resultActions;
    }
}
