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
header('Content-type: application/json');
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
$sql="select distinct company_id from nua_monthly_member_census where month_id = '2022-04' order by id";
$g=$X->sql($sql);
foreach($g as $i) {
    $data=array();
    $data['id']=$i['company_id'];
    $data['id2']="2022-04";
    $output=$F->getCompanyInvoice($data);
    print_r($output);
}
?>



