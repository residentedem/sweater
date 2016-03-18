<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use Abraham\TwitterOAuth\TwitterOAuth;

use app\models\Cache;
use yii\helpers;

class SiteController extends Controller
{
	
	public $query;
	
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
	
	public function displayIndexError($error_name) {
		$error = @Yii::$app->params['errors'][$error_name] ?: Yii::$app->params['errors']['unknown_error'];
		return $this->render('index', array(
			'error' => $error,
			'tweets' => array(),
			'tweets_count' => 0,
			'tweets_per_page' => 0,
			'query' => $this->query,
			'page' => 0
		));
	}

    public function actionIndex()
    {

		$request = Yii::$app->request;
		$session_id = session_id();
		
		$session = Yii::$app->session;
		
		if (!$session->isActive) {
			$session->open();
		}
		
		$session_id = $session->id;
		$tweets_count = 0;
		$tweets_per_page = Yii::$app->params['tweets_per_page'];
		$tweets = array();
		
		$error = array(
			'code' => 0,
			'type' => 0,
			'description' => ''
		);
		
		$statuses = array();
		
		$query = $request->get('q', NULL);
		$this->query = $query;
		$page = $request->get('p', 0);
		$caching = $request->get('caching', false);
		
		//Navigation only avaliable with caching
		if($query != NULL && $page && !$caching) {
			return $this->redirect('/?q=' . urlencodes($query), 302);
		}

		if($caching) {
			if(is_numeric($page) && $page >= 0) {
				if($page) {
					$page--;
				}
			} else {
				return $this->displayIndexError('bad_request');
			}
		}
		
		
		if($query === '') {
			return $this->displayIndexError('empty_query');
		}

		if($query !== NULL) {
			if(substr($query, 0, 1) !== '#') {
				$query = '#' . $query;
			}
			
			if(!preg_match('/^#([^\s!@#$%^&*()=+.\/,\[{\]};:\'"?><]+)$/i', $query, $matches)) {
				return $this->displayIndexError('bad_hashtag');
			}
			
			$hashtag = $matches[1];
			$cache = NULL;
			$cache_model = new Cache();
			
			if($caching) {
				
				$cache = $cache_model->getUserHashtagCache($session_id, $hashtag);

				if($cache) {
					$tweets_count = $cache_model->getUserHashtagTweetsCount($session_id, $hashtag);
					if($page * $tweets_per_page >= $tweets_count) {
						return $this->displayIndexError('bad_request');
					}
					$tweets = $cache_model->getUserHashtagTweets($session_id, $hashtag, $page * $tweets_per_page, $tweets_per_page);
					
				} else {
					return $this->redirect('/?q=' . urlencode($query), 302);
				}
			} else {
				$connection = new TwitterOAuth(Yii::$app->params['twitter_consumer_key'], Yii::$app->params['twitter_consumer_secret']);
				$statuses = $connection->get("search/tweets", ["q" => $query, "count" => 100]);
				
				if(!$statuses || $connection->getLastHttpCode() != 200 || !isset($statuses->statuses)) {
					return $this->displayIndexError('server_error');
				} 
					
				$statuses = $statuses->statuses;
			
				foreach($statuses as $status) {
					$tweets[] = array(
						'user_name' => $status->user->name,
						'user_screen_name' => $status->user->screen_name, 
						'user_profile_image_url' => $status->user->profile_image_url,
						'text' => $status->text
					);
				}
				
				if(empty($tweets)) {
					return $this->displayIndexError('no_tweets_found');
				}

				if(!$cache) {
					$cache_model->createUserHashtagCache($session_id, $hashtag, $tweets);
				}
				
				$tweets_count = count($tweets);
				$tweets = array_slice($tweets, 0, $tweets_per_page);
			}
		}
		
        return $this->render('index', array(
			'error' => $error,
			'tweets' => $tweets,
			'tweets_count' => $tweets_count,
			'tweets_per_page' => $tweets_per_page,
			'query' => $query,
			'page' => $page
		));
    }
}
