<?php
/*

File:		strings
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/helpers//strings.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core


*/

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}#function startsWith
function endsWith($haystack, $needle){
    return (strpos(strrev($haystack), strrev($needle)) === 0);   
}#function endsWith


function randomDigits($count){

    $t = "";
    $i = 0;
    while ($i<$count){
       
        $t.= "".rand(0,9);
        $i++;
    }
    return $t;
       
}#function randomDigits
 function randomLetters($count){
   
    $t = "";
    $i = 0;
    while ($i<$count){
       
        $t .= chr(rand(65,90));
        $i++;
    }
    return $t;
   
}#function randomLetters

?>