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

if ($user[0]['role']=="employee") {
$output='[
{
		"id": "home",
		"title": "Navigation",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [
                {
				"id": "db",
				"title": "Home",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/dashboard"
		},
		{
				"id": "db",
				"title": "Employee Information",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/info"
		},
		{
				"id": "db",
				"title": "Dependents",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/family"
		},
		{
				"id": "db",
				"title": "Previous Insurance",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/previous"
		},
		{
				"id": "db",
				"title": "Plans",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/plans"
		},
		{
				"id": "db",
				"title": "Medical Questionaire",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/ihq"
		},
		{
				"id": "db",
				"title": "Medications",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/medications"
		}]
}]';
   $arr=json_decode($output,true);
   $output=array();
   $output['default']=$arr;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);	
}

if ($user[0]['role']=="sadmin") {
$output='[
{
		"id": "home",
		"title": "Navigation",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [
{
				"id": "db",
				"title": "Home",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/sadmin"
		},
{
				"id": "db",
				"title": "APA Members",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/member-lookup"
		},
{
				"id": "db",
				"title": "APA Company List",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/company-list/apa"
		},
{
				"id": "db",
				"title": "APA Plan List",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/apa-plan-list"
		},
{
				"id": "db",
				"title": "Guardian Members",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/guardian-lookup"
		},
{
				"id": "db",
				"title": "Invoice List",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/invoice-list"
		},
{
				"id": "db",
				"title": "Active Company List",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/company-list/active"
		},
{
				"id": "db",
				"title": "Company List",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/company-list"
		},
{
				"id": "db",
				"title": "Employee Lookup",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/employee-lookup"
		},
{
				"id": "db",
				"title": "User List",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/user-list"
		},
{
				"id": "dbi",
				"title": "Add User",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/add-user"
		}

]
},
{
		"id": "dashboards",
		"title": "Producers",
		"subtitle": "Organizations, Companies & Quotes",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [{
				"id": "db",
				"title": "Organizations (PEOS)",
				"type": "collapsable",
				"icon": "heroicons_outline:clipboard-check",
				"children": [{
					"id": "db.add.org",
					"title": "Add Organization",
					"type": "basic",
					"link": "/add-org"
				}, {
					"id": "db.org.list",
					"title": "Organization List",
					"type": "basic",
					"link": "/org-list"
				}]
			},
			{
				"id": "prospects",
				"title": "Prospects",
				"type": "collapsable",
				"icon": "heroicons_outline:chart-pie",
				"children": [{
					"id": "db.add.org",
					"title": "Add Prospect",
					"type": "basic",
					"link": "/add-company"
				}, {
					"id": "db.org.list",
					"title": "Prospect List",
					"type": "basic",
					"link": "/company-list"
				}]
			},
			{
				"id": "rquotes",
				"title": "Pending Quotes",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/quote-request-list"
			}
		]
	},
	{
		"id": "enrollment",
		"title": "Enrollment",
		"subtitle": "Enrollments in progress",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [{
				"id": "accepted.quotes",
				"title": "Accepted Quotes",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "accepted.quotes",
					"title": "Pending ",
					"type": "basic",
					"link": "/quote-list/pending"
				}, {
					"id": "completed.quotes",
					"title": "Completed",
					"type": "basic",
					"link": "/quote-list/completed"
				}]
			}
		]
	},
	{
		"id": "apps",
		"title": "Maintenance",
		"subtitle": "Setup & Maintenance",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [
      		{
				"id": "plans",
				"title": "Plans",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.plan",
					"title": "Add Plan",
					"type": "basic",
					"link": "/add-plan"
				}, {
					"id": "plan.list",
					"title": "Plan List",
					"type": "basic",
					"link": "/plan-list"
				}]
			},
			{
				"id": "users",
				"title": "Users",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.user",
					"title": "Add User Account",
					"type": "basic",
					"link": "/add-user"
				}, {
					"id": "org.users",
					"title": "Users List",
					"type": "basic",
					"link": "/user-list/org"
				}
				]
			}
		]
	}
]';
   $arr=json_decode($output,true);
   $output=array();
   $output['default']=$arr;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);
}


if ($user[0]['role']=="user") {
$output='[
{
		"id": "home",
		"title": "Havigation",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [{
				"id": "db",
				"title": "Home",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/sadmin"
		}]
},
{
		"id": "dashboards",
		"title": "Producers",
		"subtitle": "Organizations, Companies & Quotes",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [{
				"id": "db",
				"title": "Organizations (PEOS)",
				"type": "collapsable",
				"icon": "heroicons_outline:clipboard-check",
				"children": [{
					"id": "db.add.org",
					"title": "Add Organization",
					"type": "basic",
					"link": "/add-org"
				}, {
					"id": "db.org.list",
					"title": "Organization List",
					"type": "basic",
					"link": "/org-list"
				}]
			},
			{
				"id": "prospects",
				"title": "Prospects",
				"type": "basic",
				"icon": "heroicons_outline:chart-pie",
				"link": "/company-list/prospects"
			},
			{
				"id": "rquotes",
				"title": "Add Quote Request",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/add-quote-request"
			},
			{
				"id": "rquotes",
				"title": "Requested Quotes",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/quote-request-list"
			},
			{
				"id": "quotes.pending",
				"title": "Pending Quotes",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/quote-request-list/waiting"
			}
		]
	},
	{
		"id": "enrollment",
		"title": "Enrollment",
		"subtitle": "Enrollments in progress",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [{
				"id": "accepted.quotes",
				"title": "Accepted Quotes",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "accepted.quotes",
					"title": "Pending ",
					"type": "basic",
					"link": "/quote-list/pending"
				}, {
					"id": "completed.quotes",
					"title": "Completed",
					"type": "basic",
					"link": "/quote-list/completed"
				}]
			},
			{
				"id": "apps.academy",
				"title": "Employers",
				"type": "basic",
				"icon": "heroicons_outline:academic-cap",
				"link": "/company-list/employers"
			}
		]
	},
	{
		"id": "apps",
		"title": "Maintenance",
		"subtitle": "Setup & Maintenance",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [
      		{
				"id": "orgs",
				"title": "Organizations",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.org",
					"title": "Add Organization",
					"type": "basic",
					"link": "/add-org"
				}, {
					"id": "org.list",
					"title": "Organization List",
					"type": "basic",
					"link": "/org-list"
				}]
			},
      		{
				"id": "plans",
				"title": "Plans",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.plan",
					"title": "Add Plan",
					"type": "basic",
					"link": "/add-plan"
				}, {
					"id": "plan.list",
					"title": "Plan List",
					"type": "basic",
					"link": "/plan-list"
				}]
			},
			{
				"id": "users",
				"title": "Users",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.user",
					"title": "Add User Account",
					"type": "basic",
					"link": "/add-user"
				}, {
					"id": "org.users",
					"title": "Organization Users",
					"type": "basic",
					"link": "/user-list/org"
				}, 
				{
					"id": "employer.users",
					"title": "Employer Admins",
					"type": "basic",
					"link": "/user-list/employer"
				}, 
				{
					"id": "pending.members",
					"title": "Pending Members",
					"type": "basic",
					"link": "/user-list/pending"
				}, 
				{
					"id": "enrolled.members",
					"title": "Enrolled Members",
					"type": "basic",
					"link": "/user-list/members"
				},
								{
					"id": "nuaxess.users",
					"title": "NuAxess Users",
					"type": "basic",
					"link": "/user-list/nua"
				}
				]
			}
		]
	}
]';
   $arr=json_decode($output,true);
   $output=array();
   $output['default']=$arr;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);
}

if ($user[0]['role']=="badmin"||$user[0]['role']=="broker") {
$output='[
{
		"id": "home",
		"title": "Navigation",
		"subtitle": "",
		"type": "group",
		"icon": "heroicons_outline:home",	
		"children": [{
				"id": "db",
				"title": "Home",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/badmin"
		}]
},
{
		"id": "dashboards",
		"title": "Producers",
		"subtitle": "Organizations, Companies & Quotes",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [{
				"id": "accepted.quotes",
				"title": "Prospects",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.prospect",
					"title": "Add Prospect ",
					"type": "basic",
					"link": "/add-company"
				}, {
					"id": "completed.quotes",
					"title": "Prospect List",
					"type": "basic",
					"link": "/company-list"
				}]
			},
			{
				"id": "rquotes",
				"title": "Requested Quotes",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/quote-request-list"
			},
			{
				"id": "quotes.pending",
				"title": "Pending Quotes",
				"type": "basic",
				"icon": "heroicons_outline:clipboard-check",
				"link": "/quote-request-list/waiting"
			}
		]
	},
	{
		"id": "enrollment",
		"title": "Enrollment",
		"subtitle": "Enrollments in progress",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [{
				"id": "accepted.quotes",
				"title": "Accepted Quotes",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "accepted.quotes",
					"title": "Pending ",
					"type": "basic",
					"link": "/quote-list/pending"
				}, {
					"id": "completed.quotes",
					"title": "Completed",
					"type": "basic",
					"link": "/quote-list/completed"
				}]
			}
		]
	},
	{
		"id": "apps",
		"title": "Maintenance",
		"subtitle": "Setup & Maintenance",
		"type": "group",
		"icon": "heroicons_outline:home",
		"children": [
			{
				"id": "users",
				"title": "Users",
				"type": "collapsable",
				"icon": "heroicons_outline:academic-cap",
				"children": [{
					"id": "add.user",
					"title": "Add User Account",
					"type": "basic",
					"link": "/add-user"
				}, {
					"id": "org.users",
					"title": "Organization Users",
					"type": "basic",
					"link": "/user-list/org"
				}
				]
			}
		]
	}
]';
   $arr=json_decode($output,true);
   $output=array();
   $output['default']=$arr;
   $output['compact']=array();
   $output['futuristic']=array();
   $output['horizontal']=array();   
  echo json_encode($output);
}

?>

