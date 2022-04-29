<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Content-type: application/json');
require_once('/var/www/classes/class.pages.php');
require_once('/var/www/classes/class.cmod-forms.php');
require_once('/var/www/classes/class.users.php');
require_once('/var/www/classes/class.members.php');
require_once('/var/www/classes/class.security.php');
require_once('/var/www/classes/class.messages.php');
require_once('/var/www/classes/class.quotes.php');
$P=new PAGES();
$F=new FORMS();
$U=new USERS();
$M=new MEMBERS();
$Q=new QUOTES();
$S=new SECURITY();
$TXT=new MESSAGES();
$data = file_get_contents("php://input");
$data = json_decode($data, TRUE);
$output=array();
if (!isset($data['q'])) $data['q']="vertical-menu";
$aa=explode("/",$data['q']);
if (isset($aa[1])) {
     $data['q']=$aa[1];
     if (isset($aa[2])) {
         $data['id']=$aa[2]; 
	 }
     if (isset($aa[3])) {
         $data['id2']=$aa[3]; 
	 }		 
	 if (isset($aa[4])) {
         $data['id3']=$aa[4]; 
	 }		 
}
if ($data['q']=='login') {
    $output=$F->getLogin($data);
} else {		

	if ($data['q']!="post-enroll") {
		$output=$F->start_output($data);
	} else {
		$output=array();
		$output['user']=array();
		$output['user']['force_logout']=0;
		$output['user']['force_off']=0;
	}
 	
switch ($data['q']) {
    case 'send-test-email':
       $TXT->sendMail("support@nuaxess.email", "ed@artfin.com", "Edward", "My NuAxess", "support@nuaxess.email");
        break;
case 'submit-quote':
        $output=$F->submitQuoteRequest($data);
        break;	
//-- 1
                case 'sadmin':
                     $output=$F->getTestDashboard($data);
                     break;
                case 'project-list':
                     $output=$F->getProjectList($data);
                     break;
                case 'project-dashboard':
                     $output=$F->getProjectDashboard($data);
                     break;
                case 'building-list':
                     $output=$F->getBuildingDashboard($data);
                     break;
                case 'post-add-project':
                     $output=$F->postAddProject($data,"");
                     break;
		case 'user-settings':
		case 'user-profile':
                     $output=$F->getUserProfile($data);
                     break;	
                default:
                     $output=$F->getTestDashboard($data);
                     break;
	}
}
$o=json_encode($output, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); 
//$o=json_encode($output);
//$o=stripcslashes($o);
$o=str_replace('null','""',$o);
echo $o;
?>



