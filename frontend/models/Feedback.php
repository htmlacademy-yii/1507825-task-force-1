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
 * @property Task $task0
 * @property User $user0
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
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
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
