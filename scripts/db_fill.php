<?php

declare(strict_types=1);

use TaskForce\Fixture\AnswerFixture;
use TaskForce\Fixture\CategoryFixture;
use TaskForce\Fixture\CityFixture;
use TaskForce\Fixture\FeedbackFixture;
use TaskForce\Fixture\TaskFixture;
use TaskForce\Tool\Data\Helper\EndlessConnection;

use TaskForce\Fixture\UserFixture;


include_once('../vendor/autoload.php');
include_once('../env.php');

$ec = new EndlessConnection('localhost:3306', 'root', 'root', 'taskforce');

if ($ec->getLink() == false){
    print("Cant connect to MySQL " . mysqli_connect_error() . "\n");
    die();
} else {
    print("Success connection to MySQL\n");
}

/**
 * @todo fill tables
 * [
 * DONE: categories,
 * DONE: cities,
 * opinions,
 * DONE: users + user_role + user_contact_type + user_contact,
 * feedback,
 * DONE: tasks
 * ]
 */

$fixtures = [
    new CityFixture($ec),
    new CategoryFixture($ec),
    new UserFixture($ec),
    new TaskFixture($ec),
    new FeedbackFixture($ec),
    new AnswerFixture($ec)
];

/**
 * Set true only to fill completely empty DB!!!
 */
$shouldRun = false;

$wholeSql = '';

foreach ($fixtures as $fixture){
    if ($shouldRun && $fixture instanceof \TaskForce\Fixture\Base){
        $fixture->run();
    }
    if ($fixture instanceof \TaskForce\Fixture\ILogFixture){
        $wholeSql .= $fixture->getWholeSql();
    }
}

$f = fopen(DOCUMENT_ROOT . '/dump.sql', 'w');
fwrite($f, $wholeSql);
fclose($f);



