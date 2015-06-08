<?php

function setCurrent($route, $class = 'current'){
	return (Route::currentRouteName() == $route  && !Request::has('q')) ? $class : '';
}
function setCurren($route, $class = 'current'){
	return (Request::path() == $route) ? $class : '';
}
function setCurrenq($route, $class = 'current'){
	return (Route::currentRouteName() == $route && Request::has('q')) ? $class : '';
}
function setActive($route, $class = 'current active hasSub'){
	return (Route::currentRouteName() == $route) ? $class : '';
}
function setActiv($route, $class = 'active'){
	return (Request::path() === $route) ? $class : '';
}
function setSelected($route, $class = 'selected'){
	return (Request::path() === $route) ? $class : '';
}
function tanggal($date){
	$Bulan = ["00","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
	$tahun = substr($date,0,4);
	$bulan = substr($date,5,2);
	$tgl = substr($date,8,2);
	$result = $tgl." ".$Bulan[(int)$bulan-1 < 0 ? 0 : (int)$bulan]." ".$tahun;
	return ($result);
}
function is_alay($string){
	for($i=0;$i<strlen($string);$i++){
		if(!ctype_alpha($string[$i]) && $string[$i] != '.' && $string[$i] != ',' && $string[$i] != ' ' && $string[$i] != ':' && $string[$i] != '-'){
			return true;
			break;
		}
	}
	return false;
}
function date_reverse($date,$delimiter,$glue){
	return implode($glue,array_reverse(explode($delimiter,$date)));
}
function humanFileSize($size,$unit=""){
  if( (!$unit && $size >= 1<<30) || $unit == "GB")
    return number_format($size/(1<<30),2)." GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB")
    return number_format($size/(1<<20),2)." MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB")
    return number_format($size/(1<<10),2)." KB";
  return number_format($size)." B";
}
function remove_alpha($string,$digit=''){
	for($i=0;$i<strlen($string);$i++)
		if(is_numeric($string[$i]))
			$digit .= $string[$i];
	return $digit;
}
function bulan($bulan){
	$bulan = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des"];

	return $bulan[(int)$bulan-1];
}
function address($id){
	try{
		$result = \File::get(public_path('/inc/').($id == 1 ? 'location' : 'address'));
	}catch (Illuminate\Filesystem\FileNotFoundException $exception){
		die("The file doesn't exist");
	}
	return $result;
}
function welcome(){
	try{
		$result = \File::get(public_path('/inc/dashboard'));
	}catch (Illuminate\Filesystem\FileNotFoundException $exception){
		die("The file doesn't exist");
	}
	return $result;
}
function slider(){
	try{
		$result = \File::get(public_path('/inc/slider'));
	}catch (Illuminate\Filesystem\FileNotFoundException $exception){
		die("The file doesn't exist");
	}
	return $result;
}
function slider_($id){
	try{
		$result = \File::get(public_path('/inc/slider_'));
	}catch (Illuminate\Filesystem\FileNotFoundException $exception){
		die("The file doesn't exist");
	}
	$result = array_filter(explode(' && ', $result));
	return $result[$id];
}
function gallery(){
	try{
		$result = \File::get(public_path('/inc/gallery'));
	}catch (Illuminate\Filesystem\FileNotFoundException $exception){
		die("The file doesn't exist");
	}
	return $result;
}
