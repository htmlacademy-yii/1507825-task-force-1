<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property int $user_role
 * @property string $password
 * @property string $created_at
 * @property string $last_active
 * @property float $rating
 * @property string|null $biography
 * @property int|null $avatar
 * @property string $date_of_birth
 * @property int|null $city
 * @property int|null $show_for_client
 * @property int|null $show
 *
 * @property Answer[] $answers
 * @property File $avatarObject
 * @property City $cityObject
 * @property FavoriteUser[] $favoriteUsers
 * @property Feedback[] $feedbacks
 * @property Message[] $messages
 * @property Notification[] $notifications
 * @property Task[] $ownedTasks
 * @property Task[] $executingTasks
 * @property UserCategory[] $userCategories
 * @property UserContact[] $userContacts
 * @property UserFile[] $userFiles
 * @property UserNotification[] $userNotifications
 * @property UserRole $userRole
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'first_name', 'last_name', 'user_role', 'password', 'date_of_birth'], 'required'],
            [['user_role', 'avatar', 'city', 'show_for_client', 'show'], 'integer'],
            [['created_at', 'last_active', 'date_of_birth'], 'safe'],
            [['rating'], 'number'],
            [['biography'], 'string'],
            [['email', 'first_name', 'last_name', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['user_role'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::class, 'targetAttribute' => ['user_role' => 'id']],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city' => 'id']],
            [['avatar'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['avatar' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_role' => 'User Role',
            'password' => 'Password',
            'created_at' => 'Created At',
            'last_active' => 'Last Active',
            'rating' => 'Rating',
            'biography' => 'Biography',
            'avatar' => 'Avatar',
            'date_of_birth' => 'Date Of Birth',
            'city' => 'City',
            'show_for_client' => 'Show For Client',
            'show' => 'Show',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[Avatar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(File::class, ['id' => 'avatar']);
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
     * Gets query for [[FavoriteUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteUsers() {
        return $this->hasMany(User::class, ['id' => 'owner_id'])
            ->viaTable('favorite_user', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::class, ['recipient' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwnedTasks()
    {
        return $this->hasMany(Task::class, ['client' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutingTasks()
    {
        return $this->hasMany(Task::class, ['executor' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[UserContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserContacts()
    {
        return $this->hasMany(UserContact::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[UserFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFiles()
    {
        return $this->hasMany(UserFile::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::class, ['user' => 'id']);
    }

    /**
     * Gets query for [[UserRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserRole::class, ['id' => 'user_role']);
    }
}
