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
$sql="select * from nua_monthly_member_census where apa_plan = client_plan and apa_plan <> '' and plan_type not in ('*DENTAL*','*VISION*') and company_id not in (select id from nua_company where org_id <> 17) order by id desc";
$g=$X->sql($sql);
foreach($g as $i) {
	$sql="select * from nua_company_plan where APA_CODE = '" . $i['apa_plan'] . "' and company_id = " . $i['company_id'];
	$t=$X->sql($sql);
	if (sizeof($t)>0) {
		if ($t[0]['ee_price']!="") {
		print_r($t);
               $sql="update nua_monthly_member_census set client_plan = '" . $t[0]['plan_code'] . "' where id = " . $i['id'];
		$X->execute($sql);
		}
        }
}
?>



