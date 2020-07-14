<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_notification".
 *
 * @property int $id
 * @property int $user
 * @property int $type
 * @property int $is_on
 *
 * @property NotificationType $typeObject
 * @property User $userObject
 */
class UserNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'type'], 'required'],
            [['user', 'type', 'is_on'], 'integer'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationType::class, 'targetAttribute' => ['type' => 'id']],
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
            'type' => 'Type',
            'is_on' => 'Is On',
        ];
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(NotificationType::class, ['id' => 'type']);
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
