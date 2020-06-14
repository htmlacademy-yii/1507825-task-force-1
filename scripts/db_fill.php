<?php

declare(strict_types=1);

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
 * What to fill
 * [categories, cities, opinions, users + user_role + user_contact_type + user_contact, feedback, tasks]
 */

$userFixture = new UserFixture($ec);
$userFixture->run();
