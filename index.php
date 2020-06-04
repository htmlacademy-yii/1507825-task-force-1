<?php

include_once('src/Entity/Task.php');

use TaskForce\Entity\Task;

$development = new Task(1, 2);

$tests = [
    $development->getNextStatus(Task::ACTION_ANSWER) === Task::STATUS_IN_WORK,
    $development->getNextStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELED,
    $development->getAvailableActions(Task::STATUS_NEW) === [
        Task::ACTION_ANSWER, Task::ACTION_CANCEL
    ],
    $development->perform(Task::ACTION_ANSWER),
    $development->getNextStatus(Task::ACTION_COMPLETE) === Task::STATUS_DONE,
    $development->getNextStatus(Task::ACTION_REFUSE) === Task::STATUS_FAILED,
    $development->getAvailableActions(Task::STATUS_NEW) === [
            Task::ACTION_ANSWER, Task::ACTION_CANCEL
    ],
];

$testCount = count($tests);
$successTestCount = count(array_filter($tests));

echo 'Success tests - '.$successTestCount."<br>";
echo 'Failed tests - '.($testCount - $successTestCount)."<br>";

