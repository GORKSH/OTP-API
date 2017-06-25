<?php
class OTP {
  private $db;
  function __construct ($DB_conn){
    $this->db = $DB_conn;
  }

  public function sendsms($mobile , $message){
    $username = "username";
    $mypassword = "password";
    $sendername = "TESTTO";
    $domain = "bhashsms.com/api/";
  //API Domain
    $type = "Individual"; 
  //Individual/Bulk/Group
    $lang = "English";
  //English/Other - Default is English
    $method = "POST";
    //sanitize inputs
    $username = urlencode($username);
    $mypassword = urlencode($mypassword);
    $sendername = urlencode($sendername);
    $message = urlencode($message);

    $parameters = "user=".$username."&pass=".$mypassword."&sender=".$sendername."&phone=".$mobile."&text=".$message."&Language=".$lang;
    $apiurl = "http://".$domain."/sendmsg.php";
    $ch = curl_init($apiurl);

    if($method == "POST"){
      curl_setopt($ch, CURLOPT_POST,1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
    } else {
      $get_url = $apiurl."?".$parameters;
      curl_setopt($ch, CURLOPT_POST,0);
      curl_setopt($ch, CURLOPT_URL, $get_url);
    }

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_HEADER,0);
    // DO NOT RETURN HTTP HEADERS 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    // RETURN THE CONTENTS OF THE CALL
    $return_val = curl_exec($ch);

    if($return_val=="")
      echo json_encode(array("SUCCESS" => false , "CAUSE" =>"sever_side_error"));
    else {
      echo json_encode(array("SUCCESS" => true , "RETURN" =>$return_val));
    }
  }
  
  public function generate_random_no(){
    return mt_rand(100000,999999);
  }

  public function generate_otp($mobile_no){
    $table_name="otp_verification";
    $otp=$this->generate_random_no();
    try{
      $query = $this->db->prepare("INSERT INTO `{$table_name}` (`mobile_no`, `otp`) VALUES (:mobile_no, :otp)");
      $query->bindparam(":mobile_no",$mobile_no);
      $query->bindparam(":otp",$otp);
      $query->execute();
      // $this->sendsms($mobile_no,$otp);
      echo json_encode(array("SUCCESS" => true , "OTP" =>$otp));
    }
    catch(PDOException $e){
      echo json_encode(array("SUCCESS"=>false,"CAUSE"=>$e->getMessage()));
    }
  }

  public function validate_otp($mobile_no,$otp_from_user){
    $table_name="otp_verification";
    try {
      $query = $this->db->prepare("SELECT * FROM `{$table_name}` where `mobile_no`=:mobile_no and `otp`=:otp and otpGenerationTime > DATE_SUB(now(), interval 30 minute)");
      $query->bindparam(":mobile_no",$mobile_no);
      $query->bindparam(":otp",$otp_from_user);
      $query->execute();
      $row = $query->fetchAll(PDO::FETCH_ASSOC);
      if(sizeof($row)>0){
        $result = json_encode(array("SUCCESS"=>true));
      }
      else{
        $result = json_encode(array("SUCCESS"=>false , "CAUSE"=>"otp_not_matched"));
      }
      return $result;
    }
    catch(PDOException $e){
      echo json_encode(array("SUCCESS"=>false,"CAUSE"=>$e->getMessage()));
    }
  }

}
