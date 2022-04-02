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


//-- Member Lookup
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'MEMBER-LOOKUP'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
    $child=array();
    $child['id']="db";
    $child['title']="Member Lookup";
    $child['type']="basic";
    $child['icon']="heroicons_outline:clipboard-check";
    $child['link']="/employee-lookup";
    array_push($children,$child);
}

//-- User List
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'USER-LIST'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
   $child=array();
   $child['id']="db";
   $child['title']="User List";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/user-list";
   array_push($children,$child);
}

//-- Company  List
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'COMPANY-LIST'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
   $child=array();
   $child['id']="db";
   $child['title']="Company / Prospect List";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/company-list";
   array_push($children,$child);
}

//-- Invoices
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'INVOICE-LIST'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
   $child=array();
   $child['id']="db";
   $child['title']="Invoice List";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/invoice-list";
   array_push($children,$child);
}

//-- Brokers 
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'BROKER-LIST'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
   $child=array();
   $child['id']="db";
   $child['title']="Broker List";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/broker-list";
   array_push($children,$child);
}

//-- Add User 
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'ADD-USER'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
   $child=array();
   $child['id']="db";
   $child['title']="Add User";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/add-user";
   array_push($children,$child);
}

//-- Add Orgnaization 
//
$sql="select count(*) as c from nua_exclude where user_id = " . $data['uid'] . " and func = 'ADD-USER'";
$r=$X->sql($sql);
if ($r[0]['c']=='0') {
   $child=array();
   $child['id']="db";
   $child['title']="Add Organization";
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/add-org";
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

