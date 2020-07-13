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
 * @property File $fileObject
 * @property Task $taskObject
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
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task' => 'id']],
            [['file'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file' => 'id']],
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
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file']);
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
}
