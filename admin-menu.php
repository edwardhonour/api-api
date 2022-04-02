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

$sql="select * from nua_user where id = " . $data['uid'];
$user=$X->sql($sql);

$output='[
{
		"id": "home",
		"title": "Producers",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [
{ "id": "db", "title": "Home ", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/sadmin" },
{ "id": "db", "title": "Member Lookup", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/employee-lookup" },
{ "id": "db", "title": "User List", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/user-list" },
{ "id": "db", "title": "Organization List", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/org-list" },
{ "id": "db", "title": "Company List", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/company-list" },
{ "id": "db", "title": "Invoices", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/invoice-list" },
{ "id": "db", "title": "APA Adds/Terms", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/current-additions" },
{ "id": "db", "title": "Vendors", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/vendor-list" },
{ "id": "dbi", "title": "Add User", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/add-user" },
{ "id": "dbi", "title": "Add Organization", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/add-org" }

]
}
]';

//if ($user[0]['role']=="sadmin"||$user[0]['role']=="user") {
//
   $arr=json_decode($output,true);
   $output=array();
   $output['default']=$arr;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);
//}

?>

