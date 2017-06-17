<?
/*
You can place here your functions and event handlers

AddEventHandler("module", "EventName", "FunctionName");
function FunctionName(params)
{
	//code
}
*/


function dump($var, $die = false, $all = false) {
	global $USER;
	if ($USER->IsAdmin() || $all) {
		echo '<font><pre>', print_r($var), '</pre></font>';
		
	}
	if($die) die;
}
?>