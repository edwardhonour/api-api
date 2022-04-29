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
$role=$user[0]['role'];

$menu=array();
$item=array();
$item['id']="home";
$item['title']="CMOD";
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
//-- Plans
//
$child=array();
$child['id']="db";
$child['title']="My Active Projects";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/project-list/my";
array_push($children,$child);

$child=array();
$child['id']="db";
$child['title']="Region Projects";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/project-list/region";
array_push($children,$child);

$child=array();
$child['id']="db";
$child['title']="All Projects";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/project-list/all";
array_push($children,$child);

//$child=array();
//$child['id']="db";
//$child['title']="Facilities";
//$child['type']="basic";
//$child['icon']="heroicons_outline:clipboard-check";
//$child['link']="/building-list";
//array_push($children,$child);

//$child=array();
//$child['id']="db";
//$child['title']="Users";
//$child['type']="basic";
//$child['icon']="heroicons_outline:clipboard-check";
//$child['link']="/user-list";
//array_push($children,$child);

$child=array();
$child['id']="db";
$child['title']="Completed Projects";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/project-list/completed";
array_push($children,$child);

//-- User Profile
//
$child=array();
$child['id']="db";
$child['title']="User Profile";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/user-profile";
array_push($children,$child);
//-- Company Profile
//
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

