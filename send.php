<?php

// this line loads the library 
require('twilio/Services/Twilio.php'); 
	$account_sid 	= 'ACdbdedcda4a857fc879173242c1f774fb'; 
	$auth_token 	= '035f45216f79efba8e25287345831b10'; 
	
	$status = status ();

if(isset($_POST['submit'])){
	$sms = trim($_POST['msg']);
	$bulk = trim($_POST['numbers']);
	$numbers = explode("\n", $bulk);
	$numbers = array_filter($numbers, 'trim'); // remove any extra \r characters left behind



	foreach ($numbers as $number) {
		
	 $data =  	send_sms($number,$sms);
	 $stat = 	$data->last_response->status;
	 
			if( $stat == 'queued')echo "<div class='done'>SMS sent TO ".$number."</div>"; $send = true;
	 //print_r ($data);
	}

}

if(isset($_POST['dial_num'])){
	$num = trim($_POST['dial_num']);
	call($num);	
}

function status (){
	
	 global $account_sid;
     global $auth_token;
	 
				$status = new Services_Twilio($account_sid, $auth_token);

				$account = $status->accounts->get("ACdbdedcda4a857fc879173242c1f774fb");
				return $account->status;
}

function send_sms($num, $sms){
	
	global $account_sid;
	global $auth_token;
 
				$client = new Services_Twilio($account_sid, $auth_token); 
 
 	try {
			$client->account->messages->create(array( 
			'To' => $num, 
			'From' => "+18622608245", 
			'Body' => $sms, 

  
			));



		}

	catch (Exception $e) {
	   $send = false;
	   echo "<div class='error'>Error sending to ".$num."</div>";
	} 



	return $client;
}
function call($num){
	
	 global $account_sid;
     global $auth_token;
	 
$client = new Services_Twilio($account_sid, $auth_token);

			try {
				// Initiate a new outbound call
				$call = $client->account->calls->create(
					// Step 4: Change the 'From' number below to be a valid Twilio number 
					// that you've purchased or verified with Twilio.
					"+19292442587",

					// Step 5: Change the 'To' number below to whatever number you'd like 
					// to call.
					$num,

					// Step 6: Set the URL Twilio will request when the call is answered.
					"http://demo.twilio.com/welcome/voice/"
				);
				echo "Started call: " . $call->sid;
			} 
			catch (Exception $e) {
			echo "Error: " . $e->getMessage();
			}
}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta content="index, follow" name="robots">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		
		<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,700,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
		

<style type="text/css">
.done{
	color: #555;
    font-family: Tahoma,Geneva,Arial,sans-serif;
    font-size: 11px;
    padding: 10px 10px 10px 10px;
    margin: 10px;
    background-color: #ecfff1;
    border: 1px solid #a6f5c9;

}
.error{
	color:#555;
    font-family:Tahoma,Geneva,Arial,sans-serif;font-size:11px;
    padding:10px 10px 10px 10px;
    margin:10px;
    background-color: #ffecec;
    border:1px solid #f5aca6;

}
</style>

	</head>
<body>
<form class="form-horizontal" action='' method="POST" style="">
<fieldset>

<!-- Form Name -->
<legend>Sending SMS <b style="color:<? if($status == 'active'){echo 'green'; }else {echo 'red';}?>;"><?=$status?></b></legend>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Phone Numbers</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="numbers" name="numbers" placeholder="+1..........."></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Your SMS</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="msg" name="msg"></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton">Send</label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Send</button>
  </div>
</div>
<!--<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:70%">
    70%
  </div>
</div>-->

</fieldset>
</form>

</body>
</html>