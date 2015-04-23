<?php

function setCurrent($route, $class = 'current')
{
	return (Route::currentRouteName() == $route  && !Request::has('q')) ? $class : '';
}
function setCurren($route, $class = 'current')
{
	return (Request::path() == $route) ? $class : '';
}
function setCurrenq($route, $class = 'current')
{
	return (Request::path() == $route && Request::has('q')) ? $class : '';
}
function setActive($route, $class = 'current active hasSub')
{
	return (Route::currentRouteName() == $route) ? $class : '';
}
function setActiv($route, $class = 'active')
{
	return (Request::path() === $route) ? $class : '';
}
function setSelected($route, $class = 'selected')
{
	return (Request::path() === $route) ? $class : '';
}
function tanggal($date)
{
	$Bulan = ["00","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
	$tahun = substr($date,0,4);
	$bulan = substr($date,5,2);
	$tgl = substr($date,8,2);
	$result = $tgl." ".$Bulan[(int)$bulan-1 < 0 ? 0 : (int)$bulan]." ".$tahun;
	return ($result);
}
function is_alay($string)
{
	for($i=0;$i<strlen($string);$i++)
	{
		if(!ctype_alpha($string[$i]) && $string[$i] != '.' && $string[$i] != ',' && $string[$i] != ' ')
		{
			return true;
			break;
		}
	}
	return false;
}
function humanFileSize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == "GB")
    return number_format($size/(1<<30),2)." GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB")
    return number_format($size/(1<<20),2)." MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB")
    return number_format($size/(1<<10),2)." KB";
  return number_format($size)." B";
}
