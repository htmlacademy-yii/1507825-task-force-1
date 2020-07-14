<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_contact_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property UserContact[] $userContacts
 */
class UserContactType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_contact_type';
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
     * Gets query for [[UserContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserContacts()
    {
        return $this->hasMany(UserContact::class, ['type' => 'id']);
    }
}
