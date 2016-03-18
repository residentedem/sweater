<?php
 
namespace app\commands;
 
use yii\console\Controller;
use app\models\Cache;
 
class CleanupController extends Controller {
 
    public function actionIndex() {
        echo "cron service runnning\r\n";
		
		$cache_model = new Cache();
		$deleted = $cache_model->clearExpiredCache();
		
		echo "deleted  $deleted cache entries \r\n";
		echo "cron service stops \r\n";
    }
 
}