<?php

return [
    'adminEmail' => 'admin@example.com',
	'twitter_consumer_key' => 'eA3fiC0V6u0nK8He2nSTN0bAe',
	'twitter_consumer_secret' => 'QqiMzK2fazaEliSV2NpLNYAeJSidXzb7ftSVAqCSzBmOY8EZyD',
	'tweets_per_page' => 10,
	'tweets_expires' => 3600,
	'errors' => array(
		'empty_query' => array(
			'code' => 1,
			'type' => 0,
			'description' => 'Задан пустой поисковый запроc'
		),
		'bad_hashtag' => array(
			'code' => 2,
			'type' => 0,
			'description' => 'Задан неверный хэштэг'
		),
		'server_error' => array(
			'code' => 3,
			'type' => 0,
			'description' => 'Ошибка соединения с сервером'
		),
		
		'no_tweets_found' => array(
			'code' => 4,
			'type' => 1,
			'description' => 'По вашему запросу ничего не найдено'
		),
		
		'bad_request' => array(
			'code' => 5,
			'type' => 0,
			'description' => 'Сервер не может обработать ваш запрос. Проверьте правильность введенного URL'
		),
	
		'unknown_error' => array(
			'code' => -1,
			'type' => 0,
			'description' => 'Задан пустой поисковый запроc'
		)
	) 
];
