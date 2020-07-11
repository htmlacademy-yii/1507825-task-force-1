<?php

/* @var $this yii\web\View */

$this->title = 'TaskForce';
?>

<h1>
    <?php
    /** @var app\models\User $user */
    echo $user->first_name . ' ' . $user->last_name . ', роль - ' . $user->userRole->name;
    ?>
</h1>
