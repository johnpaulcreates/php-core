<?php
/*

File:		Email
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/helpers/email.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core


function mailHTML()	- send an html email
function mailHTMLSection() - easily build a html block
*/



function mailHTML($recipient, $subject, $from, $message){

        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
       
        if (strpos($message, "<html>")==false){
            #add the html tags
            $head  = "<html>";
            $head .= "<head>";
            $head .= "<style>";
            $head .= "body{font-family: verdana,helvetica,arial,sans-serif; font-size:10px;}";
            $head .= "pre{font-family: 'Courier New', Courier, monospace; font-size:10px;}";
            $head .= "</style>";
            $head .= "<head>";
            $head .= "<body>";
           
            $message = $head . $message;
            $message .= "</body>";
            $message .= "</html>";
        }
        mail($recipient, $subject, $message, $headers);
       
}#function mailHTML
function mailHTMLSection($id, $datasource){
    $temp .= "<br><hr><br>";
    if($id!=""){
        $temp .= "<h3><a style='font-size:12px;' href='#top' title='back to top'>&and;</a>&nbsp;<a name='".$id."'>" .$id ."</a></h3>";       
    }
    $temp .= "<div id='".$id ."'>";
    $temp .= "<pre>".print_r($datasource,true)."</pre>";   
    $temp .= "</div>";
    return $temp;
}#function mailHTMLSection

?>