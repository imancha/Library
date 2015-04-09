<?php

function setCurrent($route, $class = 'current')
{
	return (Route::currentRouteName() == $route) ? $class : '';
}
function setCurren($route, $class = 'current')
{
	return (Request::path() == $route) ? $class : '';
}
function setActive($route, $class = 'current active hasSub')
{
	return (Route::currentRouteName() == $route) ? $class : '';
}
function setActiv($route, $class = 'class=active')
{
	return (Request::path() === $route) ? $class : '';
}
function setSelected($route, $class = 'selected')
{
	return (Request::path() === $route) ? $class : '';
}
function tanggal($date)
{
	$Bulan = [
		"00",
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
	];
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
		if(is_numeric($string[$i]))
		{
			return true;
			break;
		}
	}
	return false;
}
