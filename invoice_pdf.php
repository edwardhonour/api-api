	<?php
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
	header('Content-type: application/json');
	require_once('/var/www/classes/class.XRDB.php');
	require('fpdf.php');

	$X=new XRDB();

	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('logo.png',20,12,60);
			$this->SetFont('Arial','B',15);
			$this->Cell(80);
			$this->Cell(80,20,'Account Services',0,0,'R');
			$this->Ln(20);
		}

	function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}

	$company_id = "5556";
	$month_id = "2022-04";
	//$company_id=$data['id'];
	//$month_id =$data['id2'];

	$sql="select * from nua_company where id = " . $company_id;
	$co=$X->sql($sql);
	$company=$co[0];
	$company_name=$company['company_name'];
	$file_name=str_replace(" ","_",$company_name) . "_" . $month_id . ".xml";

	$sql="select * from nua_company_invoice where month_id = '" . $month_id . "' and company_id = " . $company_id;
	$inv=$X->sql($sql);
	$invoice_id=$inv[0]['id'];
	$invoice=array();
	foreach($inv[0] as $name => $value) {
		 $invoice[$name]=$value;
	}

	$sql="select * from nua_company_invoice_detail where invoice_id = " . $invoice_id . " order by invoice_order, plan_code";
	$detail=array();
	$p00=$X->sql($sql);
	foreach($p00 as $p0) {
		if ($p0['ee_qty']>0||$p0['eec_qty']>0||$p0['ees_qty']>0||$p0['fam_qty']>0) {
		   array_push($detail,$p0);
		}
	}

	$sql="select * from nua_monthly_member_census where company_id = " . $company_id . " and month_id = '" . $month_id . "' and dependent_code = '' order by last_name, first_name";
	$enrollments=array();
	$p00=$X->sql($sql);
	$count=0;
	$ee=0;
	$es=0;
	$ec=0;
	$fam=0;
	foreach($p00 as $p0) {
		   array_push($enrollments,$p0);
		   if ($p0['coverage_level']=='EE'&&$p0['plan_type']=="*MEDICAL*") $ee++;
		   if ($p0['coverage_level']=='EC'&&$p0['plan_type']=="*MEDICAL*") $ec++;
		   if ($p0['coverage_level']=='ES'&&$p0['plan_type']=="*MEDICAL*") $es++;
		   if ($p0['coverage_level']=='FAM'&&$p0['plan_type']=="*MEDICAL*") $fam++;	 
		   if ($p0['coverage_level']=='FAM'&&$p0['plan_type']=="*MEDICAL*") $count++;
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();

	if ($count<11) {

		$pdf->AddPage();
		$pdf->SetFont('Arial','B',15);
		$pdf->SetFont('Times','',12);
		$pdf->Text(10,42,$invoice['company_name']);
		$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
		$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
		$pos=77;
		$pdf->SetLineWidth(3);
		$pdf->Line(10,$pos,200,$pos);
		$pdf->SetFont('Arial','B',24);
		$pos+=15;
		$pdf->Text(10,$pos,"New Premium Payment options available");
		$pos+=15;
		$pdf->Text(10,$pos,"using the MyNuAxess Automatic Premium ");
		$pos+=15;
		$pdf->Text(10,$pos,"Payment Program!");
		$pos+=15;
		$pdf->Line(10,$pos,200,$pos);
	}
	$pos+=15;
	$pdf->SetFont('Times','',16);
	$pdf->Text(10,$pos,"Never worry about you premium payments being made on time by enrolling in ");
	$pos+=8;
	$pdf->Text(10,$pos,"the Automatic Premium Payment Program. ");
	$pos+=18;
	$pdf->Text(10,$pos,"Each month your premiums will be auto debited from your bank on the payment ");
	$pos+=8;
	$pdf->Text(10,$pos,"due date.  You will continue to receive your invoice each month via email ");
	$pos+=8;
	$pdf->Text(10,$pos,"but the payment process will be automatic.");
	$pos+=18;
	$pdf->Text(10,$pos,"Just fill out and sign the ACH payment authorization form attached to this");
	$pos+=8;
	$pdf->Text(10,$pos," statement, scan it, and email it back to billing@MyNuAxess.com");
	$pos+=18;
	$pdf->Text(10,$pos,"");
	$pdf->Text(10,$pos,"We will contact you to confirm your enrollment.");
	$pos+=28;
	$pdf->SetFont('Times','',12);
	$pdf->Text(10,$pos,"Note: Your payment due date many be adjusted to a date a few days later to comply with bank scheduling");
	$pos+=5;
	$pdf->Text(10,$pos,"requirments.");

	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Text(125,32,"Monthly Statement");		
	$pdf->SetFont('Times','',12);
	$pdf->Text(10,42,$invoice['company_name']);
	$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
	$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
	$pos=57;
	   if ($company['invoice_contact_phone']!="") {
		   $pdf->Text(10,$pos,$company['invoice_contact_phone']);
		   $pos+=5;
	   }
	   if ($company['billing_contact_email']!="") {
		   $pdf->Text(10,$pos,$company['billing_contact_email']);
		   $pos+=5;
	   }

	   if ($company['billing_contact_email2']!="") {
		   $pdf->Text(10,$pos,$company['billing_contact_email2']);
		   $pos+=5;
	   }
	   if ($company['billing_contact_email3']!="") {
		   $pdf->Text(10,$pos,$company['billing_contact_email3']);
		   $pos+=5;
	   }   
	   if ($company['billing_contact_email4']!="") {
		   $pdf->Text(10,$pos,$company['billing_contact_email4']);
		   $pos+=5;
	   }
	   if ($company['billing_contact_email5']!="") {
		   $pdf->Text(10,$pos,$company['billing_contact_email5']);
		   $pos+=5;
	   }
	   
	$pdf->Text(125,42,'Invoice Number:');
	$pdf->Text(125,47,'Invoice Month:');
	$pdf->Text(125,52,'Billing Date:');
	$pdf->Text(125,57,'Payment Due Date:');

	$pdf->Text(180,42,$invoice['invoice_number']);
	$pdf->Text(180,47,'APRIL');
	$pdf->Text(180,52,'03/15/2022');
	$pdf->Text(180,57,'03/31/2022');

	$pos+=10;

	$pdf->Text(10,$pos,'PLAN');
	$pdf->Text(50,$pos,'COVERAGE');
	$pdf->Text(105,$pos,'QTY');
	$pdf->Text(135,$pos,'PRICE');
	$pdf->Text(175,$pos,'TOTAL');
	$pos+=7;

	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$line_count=0;
	 foreach($detail as $d) {
					if ($d['ee_qty']!="0") {
							$pos+=7;
							$pdf->Text(10,$pos,$d['plan_code']);
						$pdf->Text(50,$pos,"Employee Only");
							$pdf->Text(105,$pos,$d['ee_qty']);
							$pdf->Text(135,$pos,"$" . $d['ee_price']);
							$pdf->Text(175,$pos,"$" . $d['ee_total']);
							$line_count++;
					}
					if ($d['ees_qty']!="0") {
							$pos+=7;
							$pdf->Text(10,$pos,$d['plan_code']);
						$pdf->Text(50,$pos,"Employee & Spouse Only");
							$pdf->Text(105,$pos,$d['ees_qty']);
							$pdf->Text(135,$pos,"$" . $d['ees_price']);
							$pdf->Text(175,$pos,"$" . $d['ees_total']);
													$line_count++;
					}
					if ($d['eec_qty']!="0") {
							$pos+=7;
							$pdf->Text(10,$pos,$d['plan_code']);
						$pdf->Text(50,$pos,"Employee & Children");
							$pdf->Text(105,$pos,$d['ees_qty']);
							$pdf->Text(135,$pos,"$" . $d['ees_price']);
							$pdf->Text(175,$pos,"$" . $d['ees_total']);
													$line_count++;
					}
					if ($d['fam_qty']!="0") {
							$pos+=7;
							$pdf->Text(10,$pos,$d['plan_code']);
							$pdf->Text(50,$pos,"Family");
							$pdf->Text(105,$pos,$d['fam_qty']);
							$pdf->Text(135,$pos,"$" . $d['fam_price']);
							$pdf->Text(175,$pos,"$" . $d['fam_total']);
							$line_count++;
					}
	   }
	$pos=$pos+7;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$pos+=5;
	$pdf->Text(135,$pos,'GRAND TOTAL');
	$pdf->Text(175,$pos,$invoice['grand_total']);

	$pos=135+($line_count*7);

	if ($pos>245) { 
		$pos=245;
	}
	$pdf->Text(30,$pos,'Primary ACH Instructions:');
	$pdf->Text(125,$pos,'ACH & Wire Instructions:');
	$pos+=5;
	$pdf->Text(30,$pos,'Account Name: Nuaxess Account Services');
	$pdf->Text(125,$pos,'Account Name: NuAxess 2 Inc.');		
	$pos+=5;
	$pdf->Text(30,$pos,'Bank: 5/3 Bank');
	$pdf->Text(125,$pos,'Bank: Bank of America');
	$pos+=5;
	$pdf->Text(30,$pos,'Routing Number 071923909');
	$pdf->Text(125,$pos,'ACH Routing Number (Paper/Electronic):');
	$pos+=5;
	$pdf->Text(30,$pos,'Account Number: 7242568934');
	$pdf->Text(125,$pos,'122000661/121000358');
	$pos+=5;
	$pdf->Text(30,$pos,'Bank Address: ');
	$pdf->Text(125,$pos,'Wire Routing Number: 026009593');
	$pos+=5;
	$pdf->Text(30,$pos,'38 Fountain Square Plaza');
	$pdf->Text(125,$pos,'Account Number: 325130832674');
	$pos+=5;
	$pdf->Text(30,$pos,'Cincinnati, OH 45263');
	$pdf->Text(125,$pos,'Bank Address: 287 26th St.');
	$pos+=5;
	$pdf->Text(125,$pos,'Santa Monica, CA 90402');
	$pos+=5;

	$pdf->AddPage();
	$pdf->SetFont('Times','',12);
	$pdf->Text(10,42,$invoice['company_name']);
	$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
	$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
	$pos=77;

	$pdf->Text(10,$pos,"CURRENT MONTH ENROLLMENT");
	$pos=$pos+10;

	$pdf->Text(10,$pos,'MEMBER NAME');
	$pdf->Text(75,$pos,'EFF DATE');
	$pdf->Text(105,$pos,'PLAN');
	$pdf->Text(145,$pos,'COVERAGE');
	$pdf->Text(175,$pos,'PRICE');
	$pos=$pos+7;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$last="XXX";
	   foreach($enrollments as $d) {
			if ($d['last_name'] . ', ' . $d['first_name']!=$last&&$last!="XXX") {
			   $pos+=9;
			} else {
			   $pos+=5;	
			}
			$last=$d['last_name'] . ', ' . $d['first_name'];
			$pdf->Text(10,$pos,$d['last_name'] . ', ' . $d['first_name']);
			$pdf->Text(75,$pos, $d['eff_dt']);
			$pdf->Text(105,$pos,$d['client_plan']);
			$pdf->Text(145,$pos,$d['coverage_level']);
			$pdf->Text(175,$pos,"$" . $d['coverage_price']);	   

			if ($pos>250) {
				$pdf->AddPage();
				$pdf->SetFont('Times','',12);
				$pdf->Text(10,42,$invoice['company_name']);
				$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
				$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
				$pos=77;

				$pdf->Text(10,$pos,"CURRENT MONTH ENROLLMENT (CONTINUED)");
				$pos=$pos+10;

				$pdf->Text(10,$pos,'MEMBER NAME');
				$pdf->Text(60,$pos,'EFF DATE');
				$pdf->Text(95,$pos,'PLAN');
				$pdf->Text(135,$pos,'COVERAGE');
				$pdf->Text(175,$pos,'PRICE');
				$pos=$pos+7;
				$pdf->SetLineWidth(.50);
				$pdf->Line(10,$pos,200,$pos);			
				
			}
	   }
	   if ($pos>300) {
		   $pdf->AddPage();
		   $pos=30;
	   }
	$pos=$pos+3;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);   
	$pos=$pos+15;
	$pdf->Text(135,$pos,'Employee Only');
	$pdf->Text(175,$pos,$ee);
	$pos+=5;
	$pdf->Text(135,$pos,'Employee & Spouse');
	$pdf->Text(175,$pos,$es);
	$pos+=5;
	$pdf->Text(135,$pos,'Employee & Children');
	$pdf->Text(175,$pos,$ec);						
	$pos+=5;
	$pdf->Text(135,$pos,'Family');
	$pdf->Text(175,$pos,$fam);	
	if ($count<11) {
	$pdf->AddPage();
	$pos=30;
	$pdf->SetFont('Arial','B',15);
	$pdf->Text(15,37,"Automatic Premium Payment Program");
	$pdf->SetFont('Arial','B',13);
	$pdf->Text(15,44,"Authorization Agreement");
	$pdf->SetFont('Times','',12);
	$pos=46;
	$pdf->Text(15,$pos+8,"PLEASE COMPLETE THE FOLLOWING - Print or type information");
	$pos+=15;
	$pdf->Text(15,$pos,"Yes, I elect to have my insurance premium paid monthly through the NuAxess Account Services Automatic");
	$pos+=5;
	$pdf->Text(15,$pos,"Premium Payment Program");
	$pos+=12;
	$pdf->Text(15,$pos,"Company Name: ______________________________________________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Address: _________________________________________________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"City: ___________________ State: _______ ZIP: ___________ Phone #:______________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Account Holder Name(s): ____________________________________ Phone #:________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Account Holder Address: ____________________________________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Full Name and address of Bank or Financial Institution:");
	$pos+=12;
	$pdf->Text(15,$pos,"_________________________________________________________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Bank Account Number: __________________________________  Checking OR  Savings");
	$pos+=12;
	$pdf->Text(15,$pos,"Bank Routing Number:__________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Please ensure that NuAxess Account Services is authorized to debit this account through your institutions ");
	$pos+=5;
	$pdf->Text(15,$pos,"block & filters security.");
	$pos+=12;
	$pdf->SetFont('Times','',10);
	$pdf->Text(15,$pos,"I, as account holder or authorized signer, hereby authorize NuAxess 2 Inc and/or NuAxess Account Services Company (GEX) to ");
	$pos+=5;
	$pdf->Text(15,$pos,"initiate withdrawals on a monthly basis from my account at the financial institution named in this authorization for payment of ");
	$pos+=5;
	$pdf->Text(15,$pos,"monthly NuAxess, Open Axess Cigna, Guardian, Vision Care, insurance premium due for the named policyholder; and I ");
	$pos+=5;
	$pdf->Text(15,$pos,"authorize the financial institution to charge such withdrawals to my account. ");
	$pos+=8;
	$pdf->Text(15,$pos,"A draft shall be drawn each month on or about the premium due date of the policy/contract. As the account holder, by signing ");
	$pos+=5;
	$pdf->Text(15,$pos,"below, I also certify, in the event that this draft is being drawn from a company checking account, that I am authorized to ");
	$pos+=5;
	$pdf->Text(15,$pos,"approve this transaction");
	$pos+=8;
	$pdf->Text(15,$pos,"I understand that both the financial institution and NuAxess 2 Inc and/or NuAxess Account Services reserve the right to ");
	$pos+=5;
	$pdf->Text(15,$pos,"terminate this payment program and/or my participation therein. I also understand that I may discontinue this payment ");
	$pos+=5;
	$pdf->Text(15,$pos,"program (except on individual temporary contracts) at any time with at least 10 days advance notice to NuAxess and /or ");
	$pos+=5;
	$pdf->Text(15,$pos,"NuAxess Account Services by email, online portal, and or  telephone prior to a scheduled withdrawal date. ");
	$pos+=8;
	$pdf->Text(15,$pos,"I am authorizing my insurance premium due for this NuAxess coverage, be paid as described in this agreement and agree that if ");
	$pos+=5;
	$pdf->Text(15,$pos,"any withdrawal is dishonored, the premium payment for such withdrawal will be considered in default. I also authorize the ");
	$pos+=5;
	$pdf->Text(15,$pos,"disclosure of my policy identification/group numbers and any other necessary personal information on the financial institution's ");
	$pos+=5;
	$pdf->Text(15,$pos,"statements to identify to the account holder named for whom withdrawals are being made.");
	$pos+=5;
	$pdf->AddPage();
	$pos=30;
	$pdf->SetFont('Times','',12);
	$pos=46;
	$pdf->Text(15,$pos,"I have read and accept the above agreement.");
	$pos+=12;
	$pdf->Text(15,$pos,"Authorized Signature: _________________________________________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"Date: ________________________________");
	$pos+=12;
	$pdf->Text(15,$pos,"This agreement is valid till the anniversary date of your policy and must be renewed at that time.");
	$pos+=12;
	$pdf->Text(15,$pos,"Send Completed Authorization form to:");
	$pos+=12;
	$pdf->Text(15,$pos,"NuAxess Account Services");
	$pos+=5;
	$pdf->Text(15,$pos,"billing@MyNuaxess.com");
	$pos+=5;
	$pdf->Text(15,$pos,"Or ");
	$pos+=5;
	$pdf->Text(15,$pos,"Jeff Lozinski");
	$pos+=5;
	$pdf->Text(15,$pos,"1501 Woodfield Rd, Suite 114E");
	$pos+=5;
	$pdf->Text(15,$pos,"Schaumburg IL 60173");
	$pos+=5;
	$pdf->Text(15,$pos,"Jeff@NuAxess.com");
	$pos+=5;
	$pdf->Text(15,$pos,"");
	}

	$pdf->Output();


