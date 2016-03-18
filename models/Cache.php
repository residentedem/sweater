<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cache".
 *
 * @property integer $id
 * @property string $user_session
 * @property string $hashtag
 * @property string $expires
 */
class Cache extends \yii\db\ActiveRecord
{
	

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache';
    }
	
	public static function clearExpiredCache() {
		$count = Cache::find()
			->where(['<', 'expires', date("Y-m-d H:i:s")])
			->count();
		
		Cache::deleteAll(['<', 'expires', date("Y-m-d H:i:s")]);
		
		return $count;
	}
	
	public static function getUserHashtagCache($user_session, $hashtag) 
	{
		$session_id = session_id();
		
		$cache = Cache::find()
			->where([
				'hashtag' => $hashtag,
				'user_session' => $user_session
			])
			->one();
		return $cache;
	}
	
	public static function getUserHashtagTweets($user_session, $hashtag, $offset = 0, $limit = 0) 
	{
		$cache = Cache::getUserHashtagCache($user_session, $hashtag);
		$tweets = Tweet::find()
			->where(['cache_id' => $cache->id])
			->asArray()
			->offset($offset)
			->limit($limit)
			->all();
		return $tweets;
	}
	
	public static function getUserHashtagTweetsCount($user_session, $hashtag) {
		$cache = Cache::getUserHashtagCache($user_session, $hashtag);
		
		$count = Tweet::find()
			->where(['cache_id' => $cache->id])
			->count();
		return $count;
		
		 
	}
	
	public static function createUserHashtagCache($user_session, $hashtag, $tweets = array()) 
	{
		$old_cache = Cache::getUserHashtagCache($user_session, $hashtag);
		if($old_cache) {
			$old_cache->delete();
		}
		
		$cache = new Cache();
		$cache->hashtag = $hashtag;
		$cache->user_session = $user_session;
		$cache->expires = date("Y-m-d H:i:s", time() + Yii::$app->params['tweets_expires']);  
		$cache->save(false);
		
		if(!empty($tweets)) {
			array_walk($tweets, function(&$value, $key, $cache_id){
				$value['cache_id'] = $cache_id;
			}, $cache->id); 

			
			$tweet_example = $tweets[0];
			Yii::$app->db->createCommand()->batchInsert(Tweet::tableName(), array_keys($tweet_example), $tweets)->execute();
		}
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_session', 'hashtag'], 'required'],
            [['expires'], 'safe'],
            [['user_session', 'hashtag'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_session' => 'User Session',
            'hashtag' => 'Hashtag',
            'expires' => 'Expires',
        ];
    }
}
