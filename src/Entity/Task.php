<?php


namespace TaskForce\Entity;


class Task
{
    /**
     * Statuses
     */
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    /**
     * Actions
     */
    const ACTION_CANCEL = 'cancel';
    const ACTION_ANSWER = 'answer';
    const ACTION_COMPLETE = 'complete';
    const ACTION_REFUSE = 'refuse';

    /**
     * Entity params
     */
    private $clientId;
    private $executorId;
    private $status;

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

    public function perform($action): string
    {
        $availableActions = $this->getAvailableActions($this->status);
        if (!$availableActions && in_array($action, $availableActions, true)){
            $nextStatus = $this->getNextStatus($action);
            if ($nextStatus){
                $this->status = $nextStatus;
                return $nextStatus;
            }
        }

        return false;
    }

    /**
     * @param $action
     * @return string|null
     */
    public function getNextStatus($action)
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

    public function getAvailableActions($status): array
    {
        if ($status === self::STATUS_NEW){
            return [self::ACTION_ANSWER, self::ACTION_CANCEL];
        }

        if ($status === self::STATUS_IN_WORK){
            return [self::ACTION_COMPLETE, self::ACTION_REFUSE];
        }

        return [];
    }
}
