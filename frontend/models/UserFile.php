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
 * @property File $fileObject
 * @property User $userObject
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
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
            [['file'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file' => 'id']],
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
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file']);
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
