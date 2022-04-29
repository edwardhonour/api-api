<?php

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
	
$sql="select * from nua_user where id = 553";
$user=$X->sql($sql);
if (sizeof($user)==0) {
$output='{
    "id"    : "cfaad35d-07a3-4447-a6c3-d8c3d54fd5df",
    "name"  : "User Not Found",
    "email" : "nouser@nuaxess.org",
    "avatar": "assets/images/avatars/brian-hughes.jpg",
    "status": "online"
}';
 $arr=json_decode($output,true);  
 echo json_encode($arr);
} else {
   $output=array();
   $output['id']= "cfaad35d-07a3-4447-a6c3-d8c3d54fd5df";
   $output['name']=$user[0]['first_name'] . " " . $user[0]['last_name'];
   $output['email']=$user[0]['email'];
   if ($user[0]['avatar']!="") {
		$output['avatar']=$user[0]['avatar'];
   } else {
        $output['avatar']="assets/images/avatars/brian-hughes.jpg";
   }	   
   $output['status']="online";
    echo json_encode($output);
}
?>
