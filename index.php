<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>One Time Password verification API</title>
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/otp.css">

</head>
<body>
<h3>One Time Password verification API</h3>
	<div id="container_otp_form">
		<div class="form-group">
			<label  >Your Mobile Number</label>
			<input class="form-control unicase-form-control text-input" id="mobile_no_input_field" placeholder="Mobile Number">
		</div>
		<div class="form-group">
			<label  >Enter OTP *</label>
			<input class="form-control unicase-form-control text-input" id="otp_validate_field" placeholder="Enter OTP">
		</div>
		<div class="outer-xs">
			<a href="#" class="forgot-password pull-right" id="resend_otp_btn" >Resend OTP</a>
		</div>
		<button  class="btn-upper btn btn-primary checkout-page-button" id="otp_validate_button">Submit</button>
		<div>
			<center><span id="otp_send_message"></span></center>
		</div>
	</div>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	<script src="assets/js/otp.js"></script>
</body>
</html>