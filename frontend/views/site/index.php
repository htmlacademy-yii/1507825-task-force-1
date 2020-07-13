<?php

/* @var $this yii\web\View */
/** @var app\models\User $user */


$this->title = 'TaskForce';
?>

<div>
    <p>
        <?=$user->first_name . ' ' . $user->last_name . ', роль - ' . $user->userRole->name;?>

    </p>
    <p>
        <?='Executing tasks:'?><br>
        <?php foreach ($user->executingTasks as $id => $task):?>
            <?=$id+1?>) <?= $task->title . '(' . $task->id . ')';?>
        <?php endforeach;?>
    </p>
    <p>
        <?='Owned tasks:'?><br>
        <?php foreach ($user->ownedTasks as $id => $task):?>
            <?=$id+1?>) <?= $task->title . '(' . $task->id . ')';?>
        <?php endforeach;?>
    </p>
</div>
