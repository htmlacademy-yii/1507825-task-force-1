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
 * @property NotificationType $type0
 * @property User $user0
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
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationType::className(), 'targetAttribute' => ['type' => 'id']],
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
     * Gets query for [[Type0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(NotificationType::className(), ['id' => 'type']);
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
