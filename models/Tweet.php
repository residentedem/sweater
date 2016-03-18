<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweet".
 *
 * @property integer $id
 * @property integer $cache_id
 * @property string $user_name
 * @property string $user_screen_name
 * @property string $user_profile_image_url
 * @property string $text
 */
class Tweet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tweet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cache_id', 'user_name', 'user_screen_name', 'user_profile_image_url', 'text'], 'required'],
            [['cache_id'], 'integer'],
            [['text'], 'string'],
            [['user_name', 'user_screen_name', 'user_profile_image_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cache_id' => 'Cache ID',
            'user_name' => 'User Name',
            'user_screen_name' => 'User Screen Name',
            'user_profile_image_url' => 'User Profile Image Url',
            'text' => 'Text',
        ];
    }
}
