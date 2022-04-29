<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Content-type: application/json');
require_once('/var/www/classes/class.pages.php');
require_once('/var/www/classes/class.employer-forms.php');
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
   if ($output['user']['force_logout']>0) {
		$o=json_encode($output);
		$o=stripcslashes($o);
		$o=str_replace('null','""',$o);
		echo $o; 
        die();		
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
                case 'badmin':
                     $output=$F->getTestDashboard($data);
                     break;
                case 'plan-list':
                     $output=$F->getPlanList($data);
                     break;
                case 'addition-list':
                     $output=$F->getAdditionList($data);
                     break;
                case 'termination-list':
                     $output=$F->getTerminationList($data);
                     break;
                case 'member-list':
                     $output=$F->getMemberList($data);
                     break;
//-- 2
                case 'admin-prospect-list':
                case 'prospect-list':
                    $output=$F->getCompanyList($data,'prospect');
                     break;				
//-- 3
                case 'add-prospect':
                case 'add-company':
                     $output=$F->getCompanyFormData($data);
                     break;
//-- 4
                case 'post-add-company':
                case 'post-add-prospect':
                     $output=$F->postAddCompany($data,"");
                     break;
//-- 5 
                case 'admin-quote-list':
                case 'quote-list':
                    $output=$F->getQuoteList($data);
                     break;				
//-- 6
                case 'admin-enrolling-list':
                case 'enrolling-list':
                    $output=$F->getCompanyList($data,'enrolling');
                     break;				
//-- 7
                case 'add-quote':
                case 'add-quote-request':
                    $output=$F->getQuoteRequestFormData($data);
                     break;				
//-- 8
                case 'post-add-quote':
                    $output=$F->postAddQuote($data);
                     break;				
                case 'post-add-quote-small':
                    $output=$F->postAddQuoteSmall($data);
                     break;				
//-- 9
                case 'quote-dashboard':
                    $output=$F->getQuoteDashboard($data);
                     break;				
//-- 10
                case 'edit-company':
                    $output=$F->getEditCompany($data,"nua_company");
                     break;				
                case 'post-edit-quote':
                    $output=$F->getEditQuote($data);
                     break;				
//-- 11
                case 'post-add-quote-employee':
                    $output=$F->getAddQuoteEmployee($data);
                     break;				
//-- 12
                case 'post-edit-quote-employee':
                    $output=$F->getEditQuoteEmployee($data);
                     break;				
//-- 13
                case 'post-delete-quote-employee':
                    $output=$F->getDeleteQuoteEmployee($data);
                     break;				
//-- 14
                case 'post-submit-quote':
                    $output=$F->postSubmitQuote($data);
                     break;				
//-- 15
		case 'employee-lookup':
		case 'member-lookup':
                     $output=$F->getEmployeeLookupForm($data,"nua_employee");
                     break;	
//-- 16
		case 'post-employee-lookup':
                     $output=$F->postEmployeeLookup($data);
                     break;	
//-- 17
		case 'employee-dashboard':
                     $output=$F->getEmployeeDashboard($data);
                     break;	
//-- 18
		case 'post-employee-termination':
                     $output=$F->postEmployeeTermination($data);
                     break;	
//-- 19
		case 'post-employee-addition':
                     $output=$F->postEmployeeAddition($data);
                     break;	
//-- 20
		case 'post-add-employee':
                     $output=$F->postAddEmployee($data);
                     break;	
//--21
                case 'company-list':
                case 'admin-company-list':
                     $output=$F->getCompanyList($data,'enrolled');
                     break;
//--22
                case 'company-dashboard':
                case 'census-history':
                case 'prospect-dashboard':
                     $output=$F->getCompanyDashboard($data);
                     break;
//-23
                case 'enrolling-list':
                case 'admin-enrolling-list':
                     $output=$F->getCompanyList($data,'enrolling');
                     break;
//--24
		case 'invoice-list':
		case 'admin-invoice-list':
                     $output=$F->getInvoiceList($data);
                     break;	
//--25
		case 'invoice-dashboard':
                     $output=$F->gettInvoiceDashboard($data);
                     break;	
//--26
		case 'show-invoice':
                     $output=$F->showInvoice($data);
                     break;	
//--27
		case 'admin-commission-list':
		case 'commission-list':
                     $output=$F->getCommissionList($data);
                     break;	
//--28
		case 'commission-dashboard':
                     $output=$F->gettCommissionDashboard($data);
                     break;	
//--29
		case 'user-settings':
		case 'user-profile':
                     $output=$F->getUserProfile($data);
                     break;	
		case 'org-settings':
		case 'org-profile':
                     $output=$F->getOrgProfile($data);
                     break;	
//--30
		case 'broker-list':
                     $output=$F->getBrokerList($data);
                     break;	
//--31
		case 'add-broker':
                     $output=$F->getAddBroker($data);
                     break;	
//--32
		case 'broker-dashboard':
                     $output=$F->getBrokerDashboard($data);
                     break;	
//--33
		case 'post-add-broker':
                     $output=$F->postAddBroker($data);        
                      break;	
//--34
		case 'post-invite-broker':
                     $output=$F->sendBrokerAdminInvite($data);
                      break;	
//--35
		case 'addition-list':
                     $output=$F->getAdditionList($data);
                      break;	
//--36
		case 'post-add-member-family':
                $output=$F->postAddMemberFamily($data);
                break;		
//--37
                case 'current-census':
                    $output=$F->getCurrentCensus($data);
                    break;
//--38
                case 'current-terminations':
                    $output=$F->getCurrentTerminations($data);
                    break;
//--39
                case 'current-additions':
                    $output=$F->getCurrentAdditions($data);
                    break;
//--40
        case 'post-enroll':
                $output=$F->postEnroll($data);
                break;
//--41
        case 'post-edit-user':
                $output=$F->postEditUser($data);
                break;
//--42
        case 'post-edit-broker':
                $output=$F->postEditUser($data);
                break;
//--43
		case 'send-invite':
		       $output=$F->sendInviteTxt($data);
			   break;
//--44
	    case 'post-add-employee-small':
                $output=$F->postAddEmployeeSmall($data,"nua_employee");
                break;
//--45
        case 'user-dashboard':
                $output=$F->getUserDashboard($data);
                break;
//--46
        case 'add-user':
                $output=$F->getAddUser($data);
                break;
//--47
        case 'post-edit-profile':
                $output=$F->postEditProfile($data);
                break;
        case 'post-org-profile':
                $output=$F->postOrgProfile($data);
                break;
        case 'v':
                $output=$P->getDashboardData($data);
                break;
        case 'h':
                $output=$P->getDashboardData($data);
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



