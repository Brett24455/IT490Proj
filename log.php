<?php

//public $displayErrors = ini_get('display_errors');
//$errorLog = ini_get('error_log',"errorlog.txt");

/*function writeLog() {

    if (!is_resource($this->file)) {
        $this->openLog();
    }

    fwrite($this, );
}*/

class ErrorLog
{

    public $file;
    public $errors;

    function write_error($file, $errors)
    {
        if(!is_writable($file))
            die('File is not writable');

        $log = fopen($file, 'a');

        fwrite($log, $errors);
        fclose($log);

    }
}

/*
require_once('log.php');
$ErrorLog = new ErrorLog;
$ErrorLog->Write($file, $errors);
*/
