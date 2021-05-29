<?php
$type=$_SESSION["type"];
switch($type){
case 0:
$t="先生";
break;
case 1:
$t="一般";
break;
case 2:
$t="若者";
break;
default:
$t="管理者";
break;
}    
echo $t; ?> 