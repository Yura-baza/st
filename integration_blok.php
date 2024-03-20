<?php
require('modules/st/info.dat');
$total_data="modules/st/baz.dat";
$real_data="modules/st/real.dat";
$time=time();
$now=(int)(time()/86400);
$past_time=time()-600;

$readdata=fopen($real_data,"r") or die("Не могу открыть файл $real_data");
$real_data_array=file($real_data);
fclose($readdata);

if(getenv('HTTP_X_FORWARDED_FOR'))
        $user=getenv('HTTP_X_FORWARDED_FOR');
else
        $user=getenv('REMOTE_ADDR');

$d=count($real_data_array);
for($i=0;$i<$d;$i++)
        {
        list($live_user,$last_time)=explode("::","$real_data_array[$i]");
        if($live_user!=""&&$last_time!=""):
        if($last_time<$past_time):
                $live_user="";
                $last_time="";
        endif;
        if($live_user!=""&&$last_time!="")
                {
                if($user==$live_user)
                        {
                        $real_array[]="$user::$time\r\n";
                        }
                else
                        $real_array[]="$live_user::$last_time";
                }
        endif;
        }

        if(isset($real_array)):
        foreach($real_array as $i=>$str)
                {
                if($str=="$user::$time\r\n")
                        {
                        $ok=$i;
                        break;
                        }
                }
        foreach($real_array as $j=>$str)
                {
                if($ok==$j) { $real_array[$ok]="$user::$time\r\n"; break;}
                }
       endif;

$writedata=fopen($real_data,"w") or die("Не могу открыть файл $real_data");
flock($writedata,2);
if($real_array=="") $real_array[]="$user::$time\r\n";
foreach($real_array as $str)
        fputs($writedata,"$str");
flock($writedata,3);
fclose($writedata);

$readdata=fopen($real_data,"r") or die("Не могу открыть файл $real_data");
$real_data_array=file($real_data);
fclose($readdata);
$real=count($real_data_array);

$f=fopen($total_data,"a");
$call="$user|$now\n";
$call_size=strlen($call);
flock($f,2);
fputs($f, $call,$call_size);
flock($f,3);
fclose($f);

$tarray=file($total_data);
$total_hits=count($tarray);

$today_hits_array=array();
for($i=0;$i<count($tarray);$i++)
        {
        list($ip,$t)=explode("|",$tarray[$i]);
        if($now==$t) { array_push($today_hits_array,$ip); }
        }
$today_hits=count($today_hits_array);

$total_hosts_array=array();
for($i=0;$i<count($tarray);$i++)
        {
        list($ip,$t)=explode("|",$tarray[$i]);
        array_push($total_hosts_array,$ip);
        }
$total_hosts=count(array_unique($total_hosts_array  ));

$today_hosts_array=array();
for($i=0;$i<count($tarray);$i++)
        {
        list($ip,$t)=explode("|",$tarray[$i]);
        if($now==$t) { array_push($today_hosts_array,$ip); }
        }
$today_hosts=count(array_unique($today_hosts_array  ));

		
  return '
  
    <style>
.Yura_stigan {margin: 15px 0 18px; text-align: center;}  
.Yura_stigan .block {display: inline-block; margin: 0 5px; position: relative;}  
.Yura_stigan .block div {border: 2.1px solid;border-radius: 5px 5px 0px 0px;width: 49.9px;height: 49.5px;line-height: 47px;font-size: 18px;}  
.Yura_stigan span {display: block;border-radius: 2px;width: 54px;height: 20px;line-height: 20px;font-size: 10px;color: #f3efef;text-transform: uppercase;position: absolute;right: 0px;top: 47px;text-shadow: 0 1px 0 #191717;}  
.Yura_stigan .block:nth-of-type(1) div {border-color: '.$sim['1'].';color: #1;}  
.Yura_stigan .block:nth-of-type(1) span {background: '.$sim['1'].';}  
.Yura_stigan .block:nth-of-type(2) div {border-color: '.$sim['2'].'; color: #1;}  
.Yura_stigan .block:nth-of-type(2) span {background: '.$sim['2'].';}  
.Yura_stigan .block:nth-of-type(3) div {border-color: '.$sim['3'].'; color: #1;}  
.Yura_stigan .block:nth-of-type(3) span {background: '.$sim['3'].';}

</style>




<div class="Yura_stigan">  

<div class="block">  
<div id="tugsanim">'.$total_hosts.'</div>  
<span>'.$st['1'].'</span>  
</div>  

<div class="block">  
<div id="sazredkim">'.$real.'</div>  
<span>'.$st['2'].'</span>  
</div>  

<div class="block">  
<div id="dukimlsa">'.$today_hosts.'</div>  
<span>'.$st['3'].'</span>  
</div>  

</div>  

  ';
       
return $return;

?>