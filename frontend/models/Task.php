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
 * @property Category $categoryObject
 * @property City $cityObject
 * @property User $clientObject
 * @property User $executorObject
 * @property Feedback[] $feedbacks
 * @property Message[] $messages
 * @property TaskStatus $statusObject
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
            [['client'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client' => 'id']],
            [['executor'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatus::class, 'targetAttribute' => ['status' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category' => 'id']],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city' => 'id']],
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
        return $this->hasMany(Answer::class, ['task' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['id' => 'executor']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['task' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['task' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatus::class, ['id' => 'status']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::class, ['task' => 'id']);
    }
}
