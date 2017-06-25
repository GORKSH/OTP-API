<?php
require_once '../connect.php';
$function_name = $_POST['function_name'];
if($function_name == "generate_otp"){
	$mobile_no=$_POST['mobile_no'];
	echo $otp_obj->generate_otp($mobile_no);
}
if($function_name == "validate_otp"){
	$mobile_no=$_POST['mobile_no'];
	$otp_from_user=$_POST['otp_from_user'];
	echo $otp_obj->validate_otp($mobile_no,$otp_from_user);
}
?>