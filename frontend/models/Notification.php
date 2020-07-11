<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string $created_at
 * @property int $executed
 * @property int $type
 * @property string $text
 * @property int $recipient
 *
 * @property User $recipient0
 * @property NotificationType $type0
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['executed', 'type', 'recipient'], 'integer'],
            [['type', 'text', 'recipient'], 'required'],
            [['text'], 'string'],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationType::className(), 'targetAttribute' => ['type' => 'id']],
            [['recipient'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'executed' => 'Executed',
            'type' => 'Type',
            'text' => 'Text',
            'recipient' => 'Recipient',
        ];
    }

    /**
     * Gets query for [[Recipient0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient0()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient']);
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
}
