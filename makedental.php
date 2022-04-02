<?php
//---------------------------------------------------------------------------------------------------
//
// MyNuaxess - Router Gateway for PEO Admin Module.
//           - This module is production (2/19/2022).
//           
//---------------------------------------------------------------------------------------------------
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
require_once('/var/www/classes/class.pages.php');
require_once('/var/www/classes/class.nuaxess-forms.php');
require_once('/var/www/classes/class.users.php');
require_once('/var/www/classes/class.members.php');
require_once('/var/www/classes/class.security.php');
require_once('/var/www/classes/class.messages.php');
require_once('/var/www/classes/class.quotes.php');
require_once('/var/www/classes/class.XRDB.php');
$P=new PAGES();
$F=new FORMS();
$U=new USERS();
$M=new MEMBERS();
$Q=new QUOTES();
$S=new SECURITY();
$TXT=new MESSAGES();
$X=new XRDB();
$data = file_get_contents("php://input");
$data = json_decode($data, TRUE);
$output=array();

$sql="select company_name from nua_company where id = " . $_GET['id'];
$h=$X->sql($sql);
$company_name=$h[0]['company_name'];

$sql="select * from nua_company_plan where company_id = " . $_GET['id'] . " AND plan_type = '*DENTAL*'";
$g=$X->sql($sql);
$post=array();
$post['table_name']="nua_company_plan";
$post['action']="insert";
if (sizeof($g)==0) {
    $post['plan_code']='DENTALGUARD';
    $post['APA_CODE']="GUARDHIGH";
    $post['company_id']=$_GET['id'];
    $post['company_name']=$company_name;
    $post['ee_price']="38.75";
    $post['ees_price']="78.66";
    $post['eec_price']="89.93";
    $post['fam_price']="137.71";
    $post['invoice_order']=98;
    $post['plan_type']="*DENTAL*";
    $X->post($post);
}
$sql="select * from nua_company_plan where company_id = " . $_GET['id'] . " AND plan_type = '*VISION*'";
$g=$X->sql($sql);
$post=array();
$post['table_name']="nua_company_plan";
$post['action']="insert";
if (sizeof($g)==0) {
   $post['plan_code']='VSP CHOICE';
   $post['APA_CODE']="VSP";
   $post['company_id']=$_GET['id'];
   $post['company_name']=$company_name;
   $post['ee_price']="6.82";
   $post['ees_price']="11.48";
   $post['eec_price']="11.70";
   $post['fam_price']="18.53";
   $post['invoice_order']=99;
   $post['plan_type']="*VISION*";
   $X->post($post);
}
?>
<h1>**GO BACK AND RELOAD PAGE**</h1>



