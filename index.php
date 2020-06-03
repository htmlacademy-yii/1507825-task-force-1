<?php

include_once('src/Entity/Task.php');

use TaskForce\Entity\Task;

$development = new Task(1, 2);

$tests = [
    assert($development->getNextStatus(Task::ACTION_ANSWER) == Task::STATUS_IN_WORK),
    assert($development->getNextStatus(Task::ACTION_CANCEL) == Task::STATUS_CANCELED),
    assert($development->getAvailableActions(Task::STATUS_NEW) == [
        Task::ACTION_ANSWER, Task::ACTION_CANCEL
    ]),
];

$testCount = count($tests);
$successTestCount = count(array_filter($tests));

echo 'Success tests - '.$successTestCount."<br>";
echo 'Failed tests - '.($testCount - $successTestCount)."<br>";

