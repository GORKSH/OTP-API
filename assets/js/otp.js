$(document).ready(function(){
	function validate_mobile(mobile_no){
		var otp_generate_flag=1
		if(!(mobile_no.match(/^\d+$/) && mobile_no.length==10)) {
			$("#mobile_no_input_field").val("");
			$("#mobile_no_input_field").css({"border-color": "red"});
			$("#mobile_no_input_field").attr('placeholder','* Invalid Mobile Number');
			otp_generate_flag=0;
		}
		return otp_generate_flag;
	}
	function validate_mobile_otp (mobile_no ,otp_from_user){
		var otp_validate_flag=1
		if(!(mobile_no.match(/^\d+$/) && mobile_no.length==10)) {
			$("#mobile_no_input_field").val("");
			$("#mobile_no_input_field").css({"border-color": "red"});
			$("#mobile_no_input_field").attr('placeholder','* Invalid Mobile Number');
			otp_validate_flag=0;
		}
		if(otp_from_user==''){
			$("#otp_validate_field").css({"border-color": "red"});
			$("#otp_validate_field").attr('placeholder','*Required field');
			otp_validate_flag=0;
		}
		return otp_validate_flag;
	}
	var counter=1;
	$('#otp_validate_field').focusin(function(){
		$(this).css({"border-color": ""});
		$(this).attr({"placeholder": "Enter OTP"});
	});
	$('#mobile_no_input_field').focusin(function(){
		$(this).attr({"placeholder": "Mobile No"});
		$(this).css({"border-color": ""});
	});
	
	$('#mobile_no_input_field').focusout(function(){
		var mobile_no=$(this).val();
		var otp_flag=validate_mobile(mobile_no);
		if(otp_flag==1 && counter==1){
			$.ajax({
				url: "controllers/otp.php",
				data:{mobile_no:mobile_no, function_name:"generate_otp"},
				type:"POST",
				success:function(result){
					counter=0;
					$('#mobile_no_input_field').attr("readonly","readonly");
					var data=JSON.parse(result);
					if(data['SUCCESS']==true){
						// alert("otp has been resent");
						$("#otp_send_message").text("OTP has been sent");
						$("#otp_send_message").css("color","green");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
					}
					else{
						$("#otp_send_message").text(data['CAUSE']);
						$("#otp_send_message").css("color","red");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
					}
					
				}
			});
		}
	});
	$('#resend_otp_btn').click(function(){
		var mobile_no=$('#mobile_no_input_field').val();
		var otp_flag=validate_mobile(mobile_no);
		if(otp_flag==1){
			$.ajax({
				url: "controllers/otp.php",
				data:{mobile_no:mobile_no, function_name:"generate_otp"},
				type:"POST",
				success:function(result){
					var data=JSON.parse(result);
					if(data['SUCCESS']==true){
						$("#otp_send_message").text("OTP has been resent");
						$("#otp_send_message").css("color","green");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
					}
					else{
						$("#otp_send_message").text(data['CAUSE']);
						$("#otp_send_message").css("color","red");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
					}
				}
			});
		}
	});
	$('#otp_validate_button').click(function(){
		var mobile_no=$('#mobile_no_input_field').val();
		var otp_from_user= $('#otp_validate_field').val();
		var validate_otp_flag=validate_mobile_otp (mobile_no ,otp_from_user);
		if(validate_otp_flag==1){
			$.ajax({
				url: "controllers/otp.php",
				data:{mobile_no:mobile_no,otp_from_user:otp_from_user, function_name:"validate_otp"},
				type:"POST",
				success:function(result){
					var data=JSON.parse(result);
					if(data['SUCCESS']==true){
						$("#otp_send_message").text("Mobile Number validated");
						$("#otp_send_message").css("color","green");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
						setTimeout(function(){ window.location="verified.php" }, 1200);
					}
					else if(data['SUCCESS']==false && data['CAUSE']=='otp_not_matched'){
						$("#otp_send_message").text("OTP did not match");
						$("#otp_send_message").css("color","red");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
					}
					else{
						$("#otp_send_message").text(data['CAUSE']);
						$("#otp_send_message").css("color","red");
						$("#otp_send_message").fadeIn().delay(1000).fadeOut();
					}
				}
			});
		}

	});
});