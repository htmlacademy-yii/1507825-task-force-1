<?php

declare(strict_types=1);

include_once('vendor/autoload.php');

use TaskForce\Entity\AnswerAction;
use TaskForce\Entity\CancelAction;
use TaskForce\Entity\CompleteAction;
use TaskForce\Entity\RefuseAction;
use TaskForce\Entity\Task;

$executorId = 1;
$clientId = 2;
$currentUserId = $executorId;
$currentUserId1 = $clientId;

$development = new Task($clientId, $executorId);

$tests = [
    $development->getNextStatus(new AnswerAction()) === Task::STATUS_IN_WORK,
    $development->getNextStatus(new CancelAction()) === Task::STATUS_CANCELED,
    $development->getAvailableActions(Task::STATUS_NEW, $currentUserId) == [
        new AnswerAction()
    ],
    $development->getAvailableActions(Task::STATUS_NEW, $currentUserId1) == [
        new CancelAction()
    ],
    $development->perform(new AnswerAction(), $currentUserId) === Task::STATUS_IN_WORK,
    $development->getNextStatus(new CompleteAction()) === Task::STATUS_DONE,
    $development->getNextStatus(new RefuseAction()) === Task::STATUS_FAILED,
    $development->getAvailableActions(Task::STATUS_IN_WORK, $currentUserId) == [
        new RefuseAction()
    ],
    $development->getAvailableActions(Task::STATUS_IN_WORK, $currentUserId1) == [
        new CompleteAction()
    ],
    $development->getAvailableActions(Task::STATUS_IN_WORK, 10) === [],
];


foreach ($tests as $i => $test) {
    echo ($i + 1) . ') test is ' . ($test ? 'successful' : 'failed') . '<br>';
}
