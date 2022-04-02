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

if (!isset($_GET['plan'])) $_GET['plan']="";
$level=$_GET['plan'];

$sql="select * from nua_employee where id = " . $_GET['id'];
$g=$X->sql($sql);
$employee=$g[0];

$sql="select * from nua_company where id = " . $employee['company_id'];
$h=$X->sql($sql);
$company=$h[0];

$sql="select * from nua_company_plan where company_id = " . $employee['company_id'];
$sql.=" and plan_type = '*DENTAL*'";
$p=$X->sql($sql);
$plan=$p[0];

$sql="select * from nua_monthly_member_census where employee_id = " . $_GET['id'] . " and ";
$sql.=" plan_type = '*MEDICAL*'";  
$g=$X->sql($sql);
foreach ($g as $h) {
     $post=array();
     $post['table_name']="nua_monthly_member_census";
     $post['action']="action";
     $sql="select * from nua_monthly_member_census where employee_id = " . $h['employee_id'] . " and ";
     $sql.="month_id = '" . $h['month_id'] . "' and client_plan = '" . $plan['plan_code'] . "' and company_id = " . $company['id'];
     $sql.=" and dependent_code = '" . $h['dependent_code'] . "'";
echo $sql;
     $g=$X->sql($sql);
     if (sizeof($g)>0) {
        $post['id']=$g[0]['id'];
     }
$post['client_id']=$h['client_id'];
$post['month_id']=$h['month_id'];
$post['company_id']=$h['company_id'];
$post['employee_code']=$h['employee_code'];
$post['dependent_code']=$h['dependent_code'];
$post['employee_id']=$h['employee_id'];
$post['first_name']=$h['first_name'];
$post['last_name']=$h['last_name'];
$post['middle_initial']=$h['middle_initial'];
$post['dob']=$h['dob'];
$post['ssn']=$h['ssn'];
$post['gender']=$h['gender'];
$post['eff_dt']=$h['eff_dt'];
$post['term_dt']=$h['term_dt'];
$post['client_plan']=$plan['plan_code'];
$post['apa_plan']="GUARDHIGH";
if ($level=="") { 
$post['coverage_level']=$h['coverage_level'];
} else {
$post['coverage_level']=$level;
}
if ($post['coverage_level']=="EE") $post['coverage_price']=$plan['ee_price'];
if ($post['coverage_level']=="SI") $post['coverage_price']=$plan['ee_price'];
if ($post['coverage_level']=="ES") $post['coverage_price']=$plan['ees_price'];
if ($post['coverage_level']=="EES") $post['coverage_price']=$plan['ees_price'];
if ($post['coverage_level']=="EC") $post['coverage_price']=$plan['eec_price'];
if ($post['coverage_level']=="EEC") $post['coverage_price']=$plan['eec_price'];
if ($post['coverage_level']=="FAM") $post['coverage_price']=$plan['fam_price'];
if ($post['coverage_level']=="FA") $post['coverage_price']=$plan['fam_price'];
$post['company_name']=$h['company_name'];
$post['plan_type']="*DENTAL*";
$post['grp']=$h['grp'];
$post['sub_group']=$h['sub_group'];
$post['relationship']=$h['relationship'];
$post['new_dt']=$h['new_dt'];
print_r($post);
$X->post($post);
}
?>
<h1>**GO BACK AND RELOAD PAGE**</h1>



