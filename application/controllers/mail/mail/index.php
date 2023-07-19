<?php

include("xmlapi.php");   //XMLAPI cpanel client class

// Default whm/cpanel account info

$ip = "127.0.0.1";           // should be server IP address or 127.0.0.1 if local server
$account = "comopagar";        // cpanel user account name
$passwd ="moca2015";        // cpanel user password
$port =2083;                 // cpanel secure authentication port unsecure port# 2082

$email_domain = 'comopagar.cl'; // email domain (usually same as cPanel domain)
$email_quota = 50; // default amount of space in megabytes  


/*************End of Setting***********************/

function getVar($name, $def = '') {
  if (isset($_REQUEST[$name]))
    return $_REQUEST[$name];
  else
    return $def;
}
// check if overrides passed
$email_user = getVar('user', '');
$email_pass = getVar('pass', $passwd);
$email_vpass = getVar('vpass', $vpasswd);
$email_domain = getVar('domain', $email_domain);
$email_quota = getVar('quota', $email_quota);
$dest_email = getVar('forward', '');

$msg = '';
if (!empty($email_user))
while(true) {


if ($email_pass !== $email_vpass){       //check password
$msg = "Email password does not match";
break;
}

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

if ($result->data->result == 1){
$msg = $email_user.'@'.$email_domain.' account created';
 if ($result_forward->data->result == 1){
     $msg = $email_user.'@'.$email_domain.' forward to '.$dest_email;
     }
} else {
$msg = $result->data->reason;
  break;
}

break;
}

?>
<html>
<head><title>cPanel Email Account Creator</title></head>
<body>
<?php echo '<div style="color:red">'.$msg.'</div>'; ?>
<h1>cPanel Email Account Creator</h1>
<form name="frmEmail" method="post">
<table width="400" border="0">
<tr><td>Username:</td><td><input name="user" size="20" type="text" /></td></tr>
<tr><td>Password:</td><td><input name="pass" size="20" type="password" /></td></tr>
<tr><td>Verify Password:</td><td><input name="vpass" size="20" type="password" /></td></tr>
<tr><td>Forwarder:</td><td><input name="forward" size="20" type="text" /></td></tr>
<tr><td colspan="2" align="center"><hr /><input name="submit" type="submit" value="Create Email" /></td></tr>
</table>
</form>
</body>
</html>
<html><body></body></html>