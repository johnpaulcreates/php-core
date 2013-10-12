<?php
/*

File:		Date Time
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/helpers/datetime.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core


*/



define("MYSQL_DATETIME","Y-m-d H:i:s");
define("MYSQL_DATEONLY","Y-m-d");
define("MYSQL_DATEMIDNIGHT","Y-m-d 00:00:00");





function monthNames($abbreviated=true){
    #returns an array of the months of the year
   
    if($abbreviated){
        return array(
            1 => "Jan",
            2 => "Feb",
            3 => "Mar",
            4 => "Apr",
            5 => "May",
            6 => "Jun",
            7 => "Jul",
            8 => "Aug",
            9 => "Sep",
            10 => "Oct",
            11 => "Nov",
            12 => "Dec"
            );
    }else{
        return array(
            1 => "January",
            2 => "February",
            3 => "March",
            4 => "April",
            5 => "May",
            6 => "June",
            7 => "July",
            8 => "August",
            9 => "September",
            10 => "October",
            11 => "November",
            12 => "December"
            );
    }
}#function months

function fancyFormatDateTime($data){
    #format a date and time
    #set timeFormatString="" to exclude it (ie date only)

    #some defaults
    if(isset($data['dateFormatString'])==false){$data['dateFormatString']="d M Y"; }
    if(isset($data['timeFormatString'])==false){$data['timeFormatString']="H:i"; }
    if(isset($data['showToday'])==false){$data['showToday']=true;}
    if(isset($data['showYesterday'])==false){$data['showYesterday']=true;}
    if(isset($data['showTomorrow'])==false){$data['showTomorrow']=true;}
    if(isset($data['date'])==false){$data['date']=date();}
    if(isset($data['showTimeRelative'])==false){$data['showTimeRelative']=false;}

    $isToday = false;
    $isTomorrow = false;
    $isYesterday = false;

    $date = DateTime::createFromFormat('Y-m-d G:i:i', $data['date']);
    $dateOnly = DateTime::createFromFormat('d-M-Y', $date->format('d-M-Y'));

    $today = new DateTime;
   
    $todayDateOnly = DateTime::createFromFormat( "d-M-Y",($today->format('d-M-Y')));
    $yesterdayDateOnly = clone $todayDateOnly;
    $yesterdayDateOnly->modify('-1 day');
    $tomorrowDateOnly = clone $todayDateOnly;
    $tomorrowDateOnly->modify('-1 day');

    if($dateOnly == $todayDateOnly ){
        if($data['showToday']){
            $isToday = true;
        }
    }

    if($dateOnly == $yesterdayDateOnly ){
        if($data['showYesterday']){
            $isYesterday = true;
            return( "Yesterday");
        }
    }   

    if($dateOnly == $tomorrowDateOnly ){
        if($data['showTomorrow']){
            $isomorrow = true;
        }
    }

    $fancy="";
   
    if($isToday){
        $fancy = "Today ";
        if($data['showTimeRelative']){
           
            /*
            $secs = strtotime(date()) - strtotime($data['date']);
            if($secs<1){
                $postfix = " Ago";
                $secs = $secs * -1;
            }
            */
            $fancy = fancyRelativeDateTime($data['date']);
           
            #clear the time format string so we dont overwrite it
            $data['timeFormatString']="";
        }
    }elseif($isYesterday){
        $fancy = "Yesterday ";
    }elseif($isTomorrow){
        $fancy = "Tomorrow ";
    }else{
        $fancy = date($data['dateFormatString'], strtotime($data['date']) ) . " ";
    }

    if($data['timeFormatString']!=""){
        $fancy .= date($data['timeFormatString'], strtotime($data['date']) );
    }

    return $fancy;
   
}#function fancyFormatDateTime
function fancyRelativeDateTime($date){

    if(is_null($date)){
        return "";   
    }
   
    $then = new DateTime($date);
    $now = new DateTime();
    $relative = $then->diff($now);
   
    $t = "";
    if($relative){
       
        if($relative->h>23){
            $t .= $relative->days . " days";
        }else{
            if($relative->h>0){
                $t .= $relative->h." hour";
                if($relative->h>1){
                    $t .= "s";
                }
            }
            if($relative->i>0){
                if($t!=""){
                    $t.=", ";
                }
                $t .= $relative->i." mins";
            }   
           
            if($t==""){
                $t = "0 mins";
            }           
        }

        if($then<$now){
            $t .=" ago";   
        }

    }else{
        $t .=" FAIL";
    }

    return $t;

}#functnio fancyRelativeDateTime



?>