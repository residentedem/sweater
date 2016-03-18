<?php

namespace yii\helpers;
use Yii;

class Utils
{
	public static function pre()
	{ 
		print 'sddsdasdasd'; 
	}
	
	public static function getPaginationLink($actual_page, $expected_page, $value, $link)
	{
		return ($actual_page != $expected_page ? $link . ($actual_page ? '&p=' . $value : '') : '#');
	} 
	
	
}