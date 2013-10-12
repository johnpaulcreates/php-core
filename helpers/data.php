<?php
/*

File:		data
Version:	1.0.0.0
Library: 	PHP-Core
Location: 	/helpers/data.php

Author: 	John-Paul Smith
URL: 		http://johnpaulsmith.co.uk/php-core/
GitHub: 	https://github.com/johnpaulcreates/php-core


*/


function findValueInArray($valueName, $haystack, $default = 0){
   
    if(is_array($haystack)){
        if(isset($haystack[$valueName])){
            return $haystack[$valueName];
        }else{
            return $default;   
        }       
    }else{
        #its not an array!
        return $default;
    }

}#function findValueInArray
function findParameter($paramName, $default="0"){
   
    $value=0;
    $paramName = strtolower($paramName);
   
    $value = findValueInArray($paramName,$_GET, $default);
    if("".$value != $default){
        return $value;
    }
   
    $value  = findValueInArray($paramName,$_REQUEST, $default);
    if("".$value != $default){
        return $value;
    }
   
    $value = findValueInArray($paramName,$_SESSION, $default);
    if("".$value != $default){
        return $value;
    }   
   
    return $default;
   
}#function findParameter





function showDataTable($sql, $id="", $url="", $keyfieldname="", $addIncludes=true, $target=""){
       
        if($id==="undefined" or $id==""){$id="table_".randomDigits(5);}
        if($url==="undefined"){$url=="";}
        if($keyfieldname==="undefined"){$keyfieldname="";}
        if($useDataTables==="undefined"){$useDataTables=true;}
       
        $db = new Database();
        $db->connect();
       
        $t = "<table id='".$id."'>".PHP_EOL;
        $thead=false;
        $rows = $db->query($sql);
       
        if($db->affected_rows > 0){

            while ($col = $db->fetch_array($rows)) {
                if ($thead==false){
                    #build the table header
                    $t.="<thead>".PHP_EOL."<tr>".PHP_EOL;   
                                       
                    foreach ($col as $key=>$value)
                    {
                        $t.="<th>".$key."</th>".PHP_EOL;                         
                    }#foreach
 
                    $t.="</tr>".PHP_EOL."</thead>".PHP_EOL;                   
                   
                    $thead=true;
                }#if thead
               
                $t.="<tr>".PHP_EOL;
                foreach ($col as $key=>$value)
                {
                    $t .= "<td>".PHP_EOL;
                    if($url!=""){
                        $t .= "<a href='".$url."?".$keyfieldname."=".$col[$keyfieldname]."' target='".$target."'>".PHP_EOL;
                    }
                    $t .= $value.PHP_EOL;
                    if($url!=""){
                        $t .= "</a>".PHP_EOL;
                    }                   
                    $t .= "</td>".PHP_EOL;                         
                }#foreach               
                $t.="</tr>".PHP_EOL;
               
            }#while
           
        }else{#if affected rows
            $t.="<tr><td>No Data Available</td></tr>".PHP_EOL;
        }
        $t.="</table>".PHP_EOL;
       
       
            $t .= "
            <script>
                $(document).ready(function(){
                    $('#".$id."').dataTable();
                });
            </script>";   

        if($addIncludes){
            $t.="<script language='javascript' src='http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js'></script>";
            $t.="<link rel='stylesheet' href='http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css' type='text/css' />";

        }
       
        return $t;
}#fucntion showDataTable

?>