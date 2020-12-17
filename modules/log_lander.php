<?php
	class Log{
		static protected $stack;
		
		static public function putStack($msg)
		{
			if(!is_array(self::$stack)) {
				self::$stack = array();
			}
			self::$stack[] = $msg;
		}
		
		static public function getStack()
		{
			if(!is_array(self::$stack)) {
				self::$stack = array();
			}
			return self::$stack;
		}
	}