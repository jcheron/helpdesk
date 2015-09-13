<?php
use micro\js\Jquery;
if(!isset($type)){
	$type="info";
}
$style="";
if($visible===false){
	$style='style="display:none;"';
}
echo '<div class="alert alert-'.$type.'" '.$style.'>';
	if($dismissable===true){
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	}
	echo $message;
	echo "</div>";
	if(isset($timerInterval) && $timerInterval>0){
		echo Jquery::doJquery(".alert", "hide",$timerInterval);
	}
?>