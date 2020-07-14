<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Notification[] $notifications
 * @property UserNotification[] $userNotifications
 */
class NotificationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::class, ['type' => 'id']);
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::class, ['type' => 'id']);
    }
}
