<?php
class Logger {
 	private static $fLink = false;
    private static $fileName = 'api.log';
    private static $openMode = 'a+';
    private static $dateFormat = 'Y.m.d H:i:s';
    private static $separator = ' || ';


    public function __construct() {
    	self::$fLink = fopen(dirname(__FILE__) . '/logs/' . self::$fileName, self::$openMode);
    }

    public function add($string) {
        $string = trim($string);
        $line = date(self::$dateFormat) . self::$separator . $string . PHP_EOL;
        fwrite(self::$fLink, $line);
    }

    public function __destruct() {
        if(self::$fLink) {
            fclose(self::$fLink);
        }
    }
}

?>