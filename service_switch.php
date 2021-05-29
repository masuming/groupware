<?php
$service=$_SESSION["service"];
switch($service){
case 0:
$s="希望する";
break;
case 1:
$s="希望しない";
break;
default:
    $s="未選択";
    break;
}    
echo $s; ?> 