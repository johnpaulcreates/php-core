<?php
/*

File:		Debug
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/helpers/debug.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core


function mailDebug() - send lots of debug info by email
*/

function mailDebug($description, $custom="",  $recipient = "", $reportfromall=false){
   
    $internalIP = array("81.138.23.119");

    if($recipient==""){$recipient = DEFAULT_EMAIL;}
   
    $msg = array();
   
    if (in_array($_SERVER['REMOTE_ADDR'], $internalIP)){
        $msg[] = "Internal IP Address";   
    }else{
        $msg[] = "<b>External IP Address</b>";   
    }
   
    if(isDev()){
            $msg[]="Is a Developer";
        }else{
            $msg[]="Not a developer";
    }
       
    if($reportfromall){
        #we send the report even if they are not from the office or devs

    }else{
        #only send the email from the office, or devs etc...
       
        if(isDev()==false){
            #return false;   
        }

        #only work for the office
        if (in_array($_SERVER['REMOTE_ADDR'], $internalIP)){   
        }else{
            return false;   
        }
           
    }


   
   
    #we dont need to report for certain types of files (ie not for pngs, gif, jps etc...)
    #just add the extension as it becomes an issue
    if(strpos($_SERVER['REQUEST_URI'], ".")>0 ){
        $ext = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION);
        $ignoredextensions = array("png");
        if(in_array($ext, $ignoredextensions)){
            #mail("john-paul.smith@mymoneygroup.co.uk","Extn fail: ".$ext,"");
            return false;               
        }
       
    }
   
    $time = date("H:i:s",time());
    $_SESSION['debug'][]=$description;
    $caller = array_shift(debug_backtrace());
    $line = $caller['line'];
    $file = $caller['file'];
   
    #$subject  = "" . $_SERVER[SERVER_NAME];
    $subject .= "[" .sizeof($_SESSION['debug']) . "]" . $description. " [" . $time."]: ";

    $msg[] = "REQUEST_URI: " . $_SERVER['REQUEST_URI'];
    $msg[] = "Session ID = " . session_id();
   
   
    $body .= $description ."<br>" . $file . " on line ".$line . "<BR>";
   
    if(sizeof($msg)>0){
        $body .= "<ul>";
        foreach($msg as $m){
            $body .= "<li>".$m."</li>";   
        }
        $body .= "</ul>";
    }
   
   
    $body .= mailHTMLSection("Custom:", $custom);

    $body .= mailHTMLSection("session", $_SESSION);
    $body .= mailHTMLSection("request", $_REQUEST);
    $body .= mailHTMLSection("post", $_POST);
    $body .= mailHTMLSection("get", $_GET);
    $body .= mailHTMLSection("server", $_SERVER);
    $body .= mailHTMLSection("Included Files", get_included_files());
    $body .= mailHTMLSection("backtrace", debug_backtrace());

    if (isset($custom)){
        $nav .= "<a href='#custom'>custom</a> - ";
    }
    $nav .= "<a href='#session'>session</a>";
    $nav .= " - <a href='#post'>post</a>";
    $nav .= " - <a href='#server'>server</a>";
    $nav .= " - <a href='#backtrace'>backtrace</a>";
    $nav = "<a name='top' />" .$nav;

    $body  = $nav . "<BR><BR>" . $body;
   
    mailHTML($recipient, $subject, $recipient, $body);

}#function mailDebugReport


function debugPrint($title, $data){
    debugMessage($title, $data, debug_backtrace());
}#function debugPrint
function debugMessage($title, $data, $caller){
    echo("<div class='debug_container' style='border:thin solid black; background-color: silver; margin-bottom:5px;'>");
    echo("<div class='debug_title' style='font-weight:bold;'>".$title.":</div>");
    if(is_array($data)){
        echo("<pre>".print_r($data,true)."</pre>");
    }elseif(is_object($data)){
        echo("<pre>".print_r($data,true)."</pre>");   
    }else{
        echo("<pre>".$data."</pre>");
    }
   
    echo("<div style='font-size:9px;'>");
    echo($caller[0]['file'].", line ".$caller[0]['line']);
    echo("</div>");
    echo("</div><!-- debug_container -->");   
}#fucnction debugMessage
function debugSession(){
    debugMessage("Session", $_SESSION, debug_backtrace());
}#function debugSession
function debugPost(){
    debugMessage("POST", $_POST, debug_backtrace());   
}#function debugPost
function debugDie($message, $sendEmail = true){
   
    debugMessage("die()",$message,debug_backtrace());
    if($sendEmail){
        emailDebug($message, $caller);
    }
    die();   
}#function debugDie

function getCallerMethod()
{
    $traces = debug_backtrace();

    if (isset($traces[2])) {
        return $traces[2]['function'];
    }else{
        return null;       
    }

}#function getCallerMethod


?>