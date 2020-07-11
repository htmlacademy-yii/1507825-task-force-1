<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_file".
 *
 * @property int $id
 * @property int $task
 * @property int $file
 *
 * @property File $file0
 * @property Task $task0
 */
class TaskFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task', 'file'], 'required'],
            [['task', 'file'], 'integer'],
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task' => 'id']],
            [['file'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task' => 'Task',
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[File0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile0()
    {
        return $this->hasOne(File::className(), ['id' => 'file']);
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
}
