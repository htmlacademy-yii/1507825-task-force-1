<?php

declare(strict_types=1);

use TaskForce\Fixture\CategoryFixture;
use TaskForce\Fixture\CityFixture;
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

//$cityFixture = new CityFixture($ec);
//echo $cityFixture->getWholeSql();
//$cityFixture->run();

//$categoryFixture = new CategoryFixture($ec);
//echo $categoryFixture->getWholeSql();
//$categoryFixture->run();

//$userFixture = new UserFixture($ec);
//echo $userFixture->getWholeSql();
//$userFixture->run();

//$taskFixture = new TaskFixture($ec);
//echo $taskFixture->getWholeSql();
//$taskFixture->run();


