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
$role=$user[0]['role'];

$menu=array();
$item=array();
$item['id']="home";
$item['title']="Producers";
$item['subtitle']="";
$item['type']="group";
$item['icon']="heroicons_outline:home";
$item['children']=array();

$children=array();
//-- Home
$child=array();
$child['id']="db";
$child['title']="Home";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/sadmin";
array_push($children,$child);
//-- Prospects
//
//$child=array();
//$child['id']="db";
//$child['title']="Prospects";
//$child['type']="basic";
//$child['icon']="heroicons_outline:clipboard-check";
//$child['link']="/prospect-list";
//array_push($children,$child);

//-- Quotes
//
//$child=array();
//$child['id']="db";
//$child['title']="Quotes";
//$child['type']="basic";
//$child['icon']="heroicons_outline:clipboard-check";
//$child['link']="/quote-list";
//array_push($children,$child);

//-- Active Companies
//
//$child=array();
//$child['id']="db";
//$child['title']="Active Companies";
//$child['type']="basic";
//$child['icon']="heroicons_outline:clipboard-check";
//$child['link']="/company-list";
//array_push($children,$child);

//-- Member Lookup
//
$child=array();
$child['id']="db";
$child['title']="Member Lookup";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/employee-lookup";
array_push($children,$child);

//-- Invoice Status
//
$child=array();
$child['id']="db";
$child['title']="Invoice Status";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/invoice-list";
array_push($children,$child);

//-- Commissions
//
//if ($user[0]['priv_view_commissions']=="Y") {
   $child=array();
   $child['id']="db";
   $child['title']="Commissions";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/commission-list";
   array_push($children,$child);
//}

//-- Brokers
//
if ($user[0]['priv_add_broker']=="Y") {
   $child=array();
   $child['id']="db";
   $child['title']="Brokers";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/broker-list";
   array_push($children,$child);
}

//-- Add/Terms
//
//$child=array();
//$child['id']="db";
//$child['title']="Additions";
//$child['type']="basic";
//$child['icon']="heroicons_outline:clipboard-check";
//$child['link']="/addition-list";
//array_push($children,$child);

//-- User Profile
//
$child=array();
$child['id']="db";
$child['title']="User Profile";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/user-profile";
array_push($children,$child);
//-- Org Profile
//
//
if ($role=="badmin") {
   $child=array();
   $child['id']="db";
   $child['title']="Organization Profile";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/org-profile";
   array_push($children,$child);
}
//-- Logout
//
$child=array();
$child['id']="db";
$child['title']="Sign Out";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/sign-out";
array_push($children,$child);
$item['children']=$children;

array_push($menu,$item);

   $output=array();
   $output['default']=$menu;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);

?>

