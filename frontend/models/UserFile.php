<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_file".
 *
 * @property int $id
 * @property int $user
 * @property int $file
 *
 * @property File $file0
 * @property User $user0
 */
class UserFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'file'], 'required'],
            [['user', 'file'], 'integer'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['file'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file' => 'id']],
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
            'file' => 'File',
        ];
    }

    /**
     * Gets query for [[File0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile0()
    {
        return $this->hasOne(File::className(), ['id' => 'file']);
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
