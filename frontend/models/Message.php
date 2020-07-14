<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $user
 * @property int $task
 * @property string $text
 * @property string $created_at
 *
 * @property Task $taskObject
 * @property User $userObject
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'task', 'text'], 'required'],
            [['user', 'task'], 'integer'],
            [['text'], 'string'],
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
            'task' => 'Task',
            'text' => 'Text',
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
