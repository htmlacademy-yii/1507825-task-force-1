<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $text
 * @property int $grade
 * @property string $created_at
 * @property int $task
 * @property int $user
 *
 * @property Task $taskObject
 * @property User $userObject
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'task', 'user'], 'required'],
            [['text'], 'string'],
            [['grade', 'task', 'user'], 'integer'],
            [['created_at'], 'safe'],
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'grade' => 'Grade',
            'created_at' => 'Created At',
            'task' => 'Task',
            'user' => 'User',
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
