<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property float $budget
 * @property string $date
 * @property float|null $latitute
 * @property float|null $longitute
 * @property int $status
 * @property int $category
 * @property int|null $city
 * @property int $client
 * @property int|null $executor
 * @property string $created_at
 *
 * @property Answer[] $answers
 * @property Category $category0
 * @property City $city0
 * @property User $client0
 * @property User $executor0
 * @property Feedback[] $feedbacks
 * @property Message[] $messages
 * @property TaskStatus $status0
 * @property TaskFile[] $taskFiles
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'budget', 'date', 'status', 'category', 'client'], 'required'],
            [['description'], 'string'],
            [['budget', 'latitute', 'longitute'], 'number'],
            [['date', 'created_at'], 'safe'],
            [['status', 'category', 'city', 'client', 'executor'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client' => 'id']],
            [['executor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'budget' => 'Budget',
            'date' => 'Date',
            'latitute' => 'Latitute',
            'longitute' => 'Longitute',
            'status' => 'Status',
            'category' => 'Category',
            'city' => 'City',
            'client' => 'Client',
            'executor' => 'Executor',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['task' => 'id']);
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }

    /**
     * Gets query for [[City0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity0()
    {
        return $this->hasOne(City::className(), ['id' => 'city']);
    }

    /**
     * Gets query for [[Client0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(User::className(), ['id' => 'client']);
    }

    /**
     * Gets query for [[Executor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor0()
    {
        return $this->hasOne(User::className(), ['id' => 'executor']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['task' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['task' => 'id']);
    }

    /**
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TaskStatus::className(), ['id' => 'status']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::className(), ['task' => 'id']);
    }
}
