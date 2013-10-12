<?php
/*

File:		errors
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/helpers/errors.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core


l
*/

/*
    You can enable an error handler wtih this:
    set_error_handler("errorHandler");#comment why you are doing it here

    and revert it like this:
    restore_error_handler();

   
*/
function errorHandlerIgnore($errno,$errmsg,$errfile) {      
        
        #use this handler when the we know its safe and should be ignored
       
        /* Don't execute PHP internal error handler */
        return true;  
}#function errorHandlerIgnore
function errorHandler($errno,$errmsg,$errfile) {      
        
         
        mailDebugReport("There was an error", func_get_args());
       
        echo "<h1>There was an error</h1>";
        echo "<pre>".print_r(func_get_args(),true)."</pre>";
        #throw new Exception("test");
        die();
       
        /* Don't execute PHP internal error handler */
        #return true;
         
}#function errorHandler

?>