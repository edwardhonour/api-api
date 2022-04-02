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

//$sql="select * from nua_user where id = " . $data['uid'];
//$user=$X->sql($sql);
//$role=$user[[0]['role'];

$role='padmin';
if ($role=='padmin') {

$output='[
{
		"id": "home",
		"title": "Producers",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [
{ "id": "db", "title": "Home (PEO-Admin)", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/sadmin" },
{ "id": "db", "title": "Member Lookup", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/employee-lookup" },
{ "id": "db", "title": "Company List", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/company-list" },
{ "id": "db", "title": "Terminations", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/current-terminations" },
{ "id": "dbi", "title": "Additions", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/current-additions" },
{ "id": "dbi", "title": "Invoices", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/invoice-list" },
{ "id": "dbi", "title": "Issue Log", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/system-note-list" }

]
}
]';
} else {

$output='[
{ "id": "home",
		"title": "Producers",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [
{ "id": "db", "title": "Home (PEO-Admin)", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/sadmin" },
{ "id": "db", "title": "Prospects", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/company-list/prospects" },
{ "id": "db", "title": "Pending Quotes", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/quote-list" },
{ "id": "db", "title": "Companies Enrolling", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/company-list/enrolled" },
{ "id": "db", "title": "Active Company List", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/company-list/active" },
{ "id": "db", "title": "Member Lookup", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/employee-lookup" },
{ "id": "db", "title": "Plan Enrollment", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/plan-enrollment" },
{ "id": "db", "title": "Broker List", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/user-list" },
{ "id": "dbi", "title": "Add Broker", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/add-user" },
{ "id": "dbi", "title": "Home (Broker)", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/broker-home" },
{ "id": "dbi", "title": "Home (NuAxess)", "type": "basic", "icon": "heroicons_outline:clipboard-check", "link": "/nuaxess-home" }
]
}
]';

}
   $arr=json_decode($output,true);
   $output=array();
   $output['default']=$arr;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);

?>

