<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_contact".
 *
 * @property int $id
 * @property int $type
 * @property int $user
 * @property string $value
 *
 * @property UserContactType $type0
 * @property User $user0
 */
class UserContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user', 'value'], 'required'],
            [['type', 'user'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => UserContactType::className(), 'targetAttribute' => ['type' => 'id']],
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
            'type' => 'Type',
            'user' => 'User',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Type0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(UserContactType::className(), ['id' => 'type']);
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
