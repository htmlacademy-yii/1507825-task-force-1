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
 * @property Task $task0
 * @property User $user0
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
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task' => 'id']],
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
     * Gets query for [[Task0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask0()
    {
        return $this->hasOne(Task::className(), ['id' => 'task']);
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
