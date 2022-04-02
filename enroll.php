<?php
//--------------------------------------------------------------------------
// User Enrollment Data Source.
//
// Copyright 2022 - GEX Data Labs 
//
// -- Called when user goes to the enrollment or password reset pages.
//
//--------------------------------------------------------------------------

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Content-type: application/json');


require_once('/var/www/classes/class.XRDB.php');

$X=new XRDB();

$data = file_get_contents("php://input");
$data = json_decode($data, TRUE);

$t=explode("/",$data['token']);

//-- If there is no token, put in a fake one so the query fails.

if (isset($t[2])) {
	$token=$t[2];
} else {
	$token="XXXXX";
}

$sql="select * from nua_user where invite_code = '" . $token . "'";
$users=$X->sql($sql);
$flag=0;

$formData=array();
$formData['id']=0;
$formData['email']="";
$formData['phone_mobile']="";
$formData['password']="";
$formData['password2']="";
$data['error']=0;	
		
if (sizeof($users)>0) {
	//--

	if ($users[0]['status']=='active') {
		//--
		//-- If the user is active then fail with error 2.
		//-- The user is already enrolled.
		//--
		$data['error']=2;
	} else {	
	    //--
		//-- Let the user enter or reset their password.
		//--
		$formData['id']=$users[0]['id'];
		$formData['email']=$users[0]['email'];
		$formData['phone_mobile']=$users[0]['phone_mobile'];
		$formData['password']="";
		$formData['password2']="";
		$data['error']=0;
	}
} else {
	//-- 
	//-- If there is no matching code, fail with error 0.
	//--
	$formData['id']="";
	$formData['email']="";
	$formData['phone_mobile']="";
	$formData['password']="";
	$formData['password2']="";
	$data['error']=1;
}

$data['formData']=$formData;
$o=json_encode($data);
$o=stripcslashes($o);
$o=str_replace('null','""',$o);
echo $o;

?> 
