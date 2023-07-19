<?php


function creaMailComopagar($email_user,$email_pass){

	include("xmlapi.php");   //XMLAPI cpanel client class

	// Default whm/cpanel account info

	$ip = "127.0.0.1";           // should be server IP address or 127.0.0.1 if local server
	$account = "comopagar";        // cpanel user account name
	$passwd ="moca2015";        // cpanel user password
	$port =2083;                 // cpanel secure authentication port unsecure port# 2082

	$email_domain = 'comopagar.cl'; // email domain (usually same as cPanel domain)
	$email_quota = 50; // default amount of space in megabytes  
	$dest_email = '';

	$xmlapi = new xmlapi($ip);

	$xmlapi->set_port($port);  //set port number. cpanel client class allow you to access WHM as well using WHM port.

	$xmlapi->password_auth($account, $passwd);   // authorization with password. not as secure as hash.

	// cpanel email addpop function Parameters
	$call = array(domain=>$email_domain, email=>$email_user, password=>$email_pass, quota=>$email_quota);
	// cpanel email fwdopt function Parameters
	$call_f  = array(domain=>$email_domain, email=>$email_user, fwdopt=>"fwd", fwdemail=>$dest_email);
	$xmlapi->set_debug(0);      //output to error file  set to 1 to see error_log.

	// making call to cpanel api
	$result = $xmlapi->api2_query($account, "Email", "addpop", $call ); 
	$result_forward = $xmlapi->api2_query($account, "Email", "addforward", $call_f); //create a forward  
	//for debugging purposes. uncomment to see output
	//echo 'Result\n<pre>';
	//print_r($result);
	//echo '</pre>';

	return true;

}
?>