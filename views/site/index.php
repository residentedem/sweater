<?php
use yii\helpers\Utils;    
/* @var $this yii\web\View */

$this->title = 'Sweater -- Лучший поиcковик в Tweeter';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать на Sweater!</h1>
		<p>Данный портал предназначен, для поиска постов по хэштегам на сайте Twitter</p>
		<p>Что бы начать поиск, введите интересующий вас хэштег и нажмите Найти!</p>
    </div>


    <div class="body-content">
		<form action="/" method="GET">
			<div class="row">
				<div class="input-group">
					
						<input name="q" type="text" class="form-control" placeholder="Введите хэштег для поиска" value="<?=$query; ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Найти!</button>
						</span>
					
				</div>
			</div>
		</form>
		<?php if($error['code']) { ?>
			<div class="search-error__wrapper">
				<div class="alert alert-<?=($error['type'] == 0 ? 'danger' : 'warning');?>" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<?php if($error['type'] == 0) {?>
						<span class="sr-only">Error:</span>
						<span>Ошибка:</span>
					<?php } ?>
					<span><?=$error['description'];?></span>
				</div>
			
			</div>
		<?php } ?>
		
		<?php 
			if(!empty($tweets)) { 
				foreach($tweets as $tweet) {
		?>
					<div class="panel panel-primary tweet__frame ">
						<div class="panel-heading tweet__heading"> 
							<img src="<?=$tweet['user_profile_image_url'];?>" class="avatar" />
							<span class="panel-title"><span class="tweet__heading-name"><?=$tweet['user_name'];?></span> <span>@<?=$tweet['user_screen_name'];?></span></span> 
						</div>
						<div class="panel-body">
							<?=$tweet['text'];?>
						</div>
					</div>
		<?php		
				}
			} 
		?>
		<?php if(!empty($tweets)) { ?>
		<nav> 
			<ul class="pagination"> 
			<li <?=($page ==  0 ? 'class="active"' : '')?>><a href="<?=Utils::getPaginationLink($page, 0, $page, '?q=' . urlencode($query) . '&caching=true'); ?>" aria-label="Предыдущая страница"><span aria-hidden="true">«</span></a></li>				
				<?php for($i = 0; $i < ceil($tweets_count / $tweets_per_page); $i++) { ?>
					<li <?=($i == $page ? 'class="active"' : '')?>><a href="<?=Utils::getPaginationLink($i, $page, $i + 1, '?q=' . urlencode($query) . '&caching=true'); ?>"><?=$i + 1;?></a></li> 
				<?php } ?>	
				
				<li <?=($page + 1 ==  ceil($tweets_count / $tweets_per_page)? 'class="active"' : '')?>><a href="<?=Utils::getPaginationLink($page + 1, ceil($tweets_count / $tweets_per_page), $page + 2, '?q=' . urlencode($query) . '&caching=true'); ?>" aria-label="Следующая страница"><span aria-hidden="true">»</span></a></li>				
			</ul> 
		</nav>
		<?php } ?>
    </div>
</div>
