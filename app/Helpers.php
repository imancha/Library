<?php

function setCurrent($route, $class = 'current')
{
	return (Route::currentRouteName() == $route) ? $class : '';
}
function setActive($route, $class = 'current active hasSub')
{
	return (Route::currentRouteName() == $route) ? $class : '';
}
function setActiv($route, $class = 'active')
{
	return (Request::path() === $route) ? $class : '';
}
function bulan($i)
{
	$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
	return $bulan[$i];
}
