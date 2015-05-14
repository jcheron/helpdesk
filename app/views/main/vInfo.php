<?php
if(!isset($type)){
	$type="info";
}
echo '<div class="alert alert-'.$type.'">';
	if($dismissable===true){
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	}
	echo $message;
	echo "</div>";
	if(isset($timerInterval) && $timerInterval>0){
		echo JsUtils::doSomethingOn(".alert", "hide",$timerInterval);
	}
?>