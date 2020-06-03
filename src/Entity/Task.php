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
    private $clientId = null;
    private $executorId = null;
    private $status = self::STATUS_NEW;

    public function __construct(int $clientId, int $executorId)
    {
        $this->clientId = $clientId;
        $this->executorId = $executorId;
    }

    public function getNextStatus($action): string
    {

        if (!$this->status || !$action) return null;

        if ($this->status === self::STATUS_NEW){
            if ($action === self::ACTION_ANSWER) return self::STATUS_IN_WORK;
            if ($action === self::ACTION_CANCEL) return self::STATUS_CANCELED;
        }

        if ($this->status === self::STATUS_IN_WORK){
            if ($action === self::ACTION_COMPLETE) return self::STATUS_DONE;
            if ($action === self::ACTION_REFUSE) return self::STATUS_FAILED;
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

        return null;
    }
}
