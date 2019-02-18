<?php
class DLogger {
	
	
	public static function logger($classname,$message,$level = 'INFO') {
		echo "$classname::$message"."\n" ;
	}

}

?>