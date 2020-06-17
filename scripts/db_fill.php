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

global $DOCUMENT_ROOT;

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
    'city' => new CityFixture($ec, $DOCUMENT_ROOT . '/data/cities.csv'),
    'category' => new CategoryFixture($ec, $DOCUMENT_ROOT . '/data/categories.csv'),
    'user' => new UserFixture($ec, $DOCUMENT_ROOT . '/data/users.csv', [
        'role' => $DOCUMENT_ROOT . '/data/user_role.csv',
        'contact_type' => $DOCUMENT_ROOT . '/data/user_contact_type.csv',
        'contact' => $DOCUMENT_ROOT . '/data/user_contact.csv'
    ]),
    'task' => new TaskFixture($ec, $DOCUMENT_ROOT . '/data/tasks.csv', [
        'status' => $DOCUMENT_ROOT . '/data/status.csv'
    ]),
    'feedback' => new FeedbackFixture($ec, $DOCUMENT_ROOT . '/data/opinions.csv'),
    'answer' => new AnswerFixture($ec, $DOCUMENT_ROOT . '/data/replies.csv')
];

/**
 * Set true only to fill completely empty DB!!!
 */
$shouldRun = false;

$dumpIndex = 0;
foreach ($fixtures as $entity => $fixture){
    $dumpIndex++;
    if ($shouldRun && $fixture instanceof \TaskForce\Fixture\Base){
        $fixture->run();
    }
    if ($fixture instanceof \TaskForce\Fixture\ILogFixture){
        $wholeSql = $fixture->getWholeSql();

        $f = fopen($DOCUMENT_ROOT . '/dumps/'.$dumpIndex.'.'.$entity.'.sql', 'w');
        fwrite($f, $wholeSql);
        fclose($f);
    }
}





