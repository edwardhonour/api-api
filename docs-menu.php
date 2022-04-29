
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
$item['title']="User Guides";
$item['subtitle']="";
$item['type']="group";
$item['icon']="heroicons_outline:home";
$item['children']=array();

$children=array();
//-- Home
//
$sql="select * from nua_guide_category order by category_order";
$list=$X->sql($sql);

$child=array();
$child['id']="db";
$child['title']="Home";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/sadmin";
array_push($children,$child);

foreach($list as $l) {

   $child=array();
   $child['id']="db";
   $child['title']=$l['category_name'];
   $child['type']="basic";
   $child['icon']="heroicons_outline:clipboard-check";
   $child['link']="/category-home/" . $l['id'];
   array_push($children,$child);

}

$child=array();
$child['id']="db";
$child['title']="Admin";
$child['type']="basic";
$child['icon']="heroicons_outline:clipboard-check";
$child['link']="/category-list";
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

