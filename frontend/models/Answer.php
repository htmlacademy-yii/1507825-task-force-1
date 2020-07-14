<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int $user
 * @property string|null $description
 * @property float $budget
 * @property int $task
 * @property string $created_at
 *
 * @property Task $taskObject
 * @property User $userObject
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'budget', 'task'], 'required'],
            [['user', 'task'], 'integer'],
            [['description'], 'string'],
            [['budget'], 'number'],
            [['created_at'], 'safe'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'description' => 'Description',
            'budget' => 'Budget',
            'task' => 'Task',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
}
