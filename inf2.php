	<?php
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
	header('Content-type: application/json');
	require_once('/var/www/classes/class.XRDB.php');
	require('fpdf.php');
        require 'vendor/autoload.php';
        use MailerSend\MailerSend;
        use MailerSend\Helpers\Builder\Attachment;
        use MailerSend\Helpers\Builder\Recipient;
        use MailerSend\Helpers\Builder\EmailParams;
        use MailerSend\Helpers\Builder\Variable;

	$X=new XRDB();

$mailersend = new MailerSend(['api_key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDYzMzk5ZWJkYjU3OGZiYjRjMTNhYTkyMzdjOWVjYzBhNjQ4ODhmNmY5Zjg4ZWM2ODNjMmEwOGQ3NTAxYWE5MTc1MzM1NTZkYzQ1ZGM1MjAiLCJpYXQiOjE2NDc1NDY5MDYuNDU3MjcyLCJuYmYiOjE2NDc1NDY5MDYuNDU3Mjc3LCJleHAiOjQ4MDMyMjA1MDYuNDUyMzg3LCJzdWIiOiIxODI1MSIsInNjb3BlcyI6WyJlbWFpbF9mdWxsIiwiZG9tYWluc19mdWxsIiwiYWN0aXZpdHlfZnVsbCIsImFuYWx5dGljc19mdWxsIiwidG9rZW5zX2Z1bGwiLCJ3ZWJob29rc19mdWxsIiwidGVtcGxhdGVzX2Z1bGwiLCJzdXBwcmVzc2lvbnNfZnVsbCJdfQ.Nr2ZcwmziDLNOnBnZSEv8FVpHVK0apfeFkPGiS9QAJgNo0lpOJu8mUAgVULzYbcYx7OYqOaLsfEb-2MoQ3CgwKpa3qFkxOPQUu5qn1UgfmvwYpe7sLeYJgGMsRuqtvRmqQFO5Aq2B8ar0PzVfa010lnEkZrD_9mNQKogC-mGUOmBJNhHjB3X9uTy7iF2kntWyEynQgS0vK2MYrkbmDglcpG6j3Jfu_b0zR2tvi4K9MjywrJ6XBShJqcymZaq3WagM-7crbyVH_6Rh9spgEVWLDeexj1qXJeUrPUidkhDiCoosuWjq9R0NKhZnd3eKyvOE8dYSNjkt316B2-UcyGqED93zYZJdOWpHlciEfP5qoOzIP8SH-XyCmXINfJ6mPcqoUev4P6i6DDYzN5wBoZ6bZDynl8qZ9u9Q4R33lyOP0TddLw2KFrHULNJHhxAhT078pPMX76vebpz56Qbtvdoaw-VNMe5LeQeEGrHuZ3BvE489p8cjDxhMlVOX1klJwSk9ChU01maPhvofXpxyf1N2nAxAVXp-J89E1BbKkMkQdT8gqf9vbrubbugI696plhQDXId0HBfKh5LP4ToBembMzKrB6WY-nvYQXoEtGfVU3vMzK8U0z5jLjtNHKiwMeDZBgA7ib75UyG4RlMmshO28lDKEWZuSstuKe7vuUnTx6U']);

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

	if (isset($argv[1])) { $_GET['id']=$argv[1]; $_GET['display']="F"; } 
	if (isset($argv[2])) { $_GET['display']=$argv[2]; } 

	if (isset($_GET['display'])) {
		$display = $_GET['display'];
	} else {
                $display = "B";
	}

	$month_id = "2022-04";

        if ($month_id=="2022-01") { $post['billing_date']="12/05/2021"; $post['due_date']="12/31/2021"; }
        if ($month_id=="2022-02") { $post['billing_date']="01/05/2022"; $post['due_date']="01/31/2022"; }
        if ($month_id=="2022-03") { $post['billing_date']="02/05/2022"; $post['due_date']="02/28/2022"; }
        if ($month_id=="2022-04") { $post['billing_date']="03/15/2022"; $post['due_date']="03/31/2022"; }
        if ($month_id=="2022-05") { $post['billing_date']="04/01/2022"; $post['due_date']="04/30/2022"; }


        $sql="select * from nua_company_invoice where month_id = '" . $month_id . "' and company_id in (select id from nua_company where org_id = 17)";
        $grand=0;
        $medical=0;
        $dental=0;
        $vision=0;
        $add=0;
        $z=$X->sql($sql);
        foreach ($z as $a) {
                $grand+=floatval(str_replace(',','',$a['grand_total']));
                $medical+=floatval(str_replace(',','',$a['medical_total']));
                $dental+=floatval(str_replace(',','',$a['dental_total']));
                $vision+=floatval(str_replace(',','',$a['vision_total']));
                $add+=floatval(str_replace(',','',$a['add_total']));
        }
        $grand_total=number_format($grand,2);
        $medical_total=number_format($medical,2);
        $other_total=number_format($dental+$vision+$add,2);

	$file_name="INFINITI_HR_MASTER_INVOICE_" . $month_id . ".pdf";

	$pdf = new PDF();
	$pdf->AliasNbPages();
        $invite_total_float=0;
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Text(125,32,"Monthly Master Statement");		
	$pdf->SetFont('Times','',12);
	$pdf->Text(10,42,"INFINITI HR CORP");
	$pdf->Text(10,47,"3905 NATIONAL DRIVE");
	$pdf->Text(10,52,"BURTONSVILLE, MD 20866");
	$pos=57;
	$pdf->Text(125,42,'Invoice Number:');
	$pdf->Text(125,47,'Invoice Month:');
	$pdf->Text(125,52,'Billing Date:');
	$pdf->Text(125,57,'Payment Due Date:');

	$pdf->Text(175,42,"IFHR-2022-04");
	$pdf->Text(175,47,'APRIL');
	$pdf->Text(175,52,'03/15/2022');
	$pdf->Text(175,57,'03/31/2022');

	$pos+=20;

	$pdf->Text(10,$pos,'CATEGORY');
//	$pdf->Text(50,$pos,'COVERAGE');
//	$pdf->Text(105,$pos,'QTY');
	$pdf->Text(133,$pos,'COUNT');
	$pdf->Text(175,$pos,'TOTAL');
	$pos+=7;
        $medical_count=0;
        $dental_count=0;
        $vision_count=0;
        $add_count=0;

	$sql="select plan_type from nua_monthly_member_census where month_id = '" . $month_id . "' and ";
	$sql.=" company_id in (select id from nua_company where org_id = 17)";
        $tt=$X->sql($sql);
        foreach($tt as $t) {
            if ($t['plan_type']=="*MEDICAL*") $medical_count++;
            if ($t['plan_type']=="*DENTAL*") $medical_count++;
            if ($t['plan_type']=="*VISION*") $vision_count++;
            if ($t['plan_type']=="*ADD*") $add_count++;
            if ($t['plan_type']=="*LIFE*") $add_count++;

	}	

	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$line_count=0;
	$pos+=7;
	$pdf->Text(10,$pos, "OpenAxess Medical");
	$pdf->Text(135,$pos,$medical_count);
	$pdf->Text(175,$pos,"$" . number_format($medical,2));
	$pos+=7;
	$pdf->Text(10,$pos, "Guardian Dental");
	$pdf->Text(135,$pos,$dental_count);
	$pdf->Text(177,$pos,"$" . number_format($dental,2));
	$pos+=7;
	$pdf->Text(10,$pos, "Vision");
	$pdf->Text(135,$pos,$vision_count);
	$pdf->Text(177,$pos,"$" . number_format($vision,2));
	$pos+=7;
	$pdf->Text(10,$pos, "ADD/Life");
	$pdf->Text(135,$pos,$add_count);
	$pdf->Text(179,$pos,"$" . number_format($add,2));
	$pos=$pos+7;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$pos+=5;
	$pdf->Text(135,$pos,'GRAND TOTAL');
	$pdf->Text(175,$pos,"$" . $grand_total);

	$pos=135+($line_count*7);

        $pdf->Text(30,$pos,'ACH Instructions:');
        $pos+=5;
        $pdf->Text(30,$pos,'Account Name: Nuaxess Account Services');
        $pos+=5;
        $pdf->Text(30,$pos,'Bank: 5/3 Bank');
        $pos+=5;
        $pdf->Text(30,$pos,'Routing Number 071923909');
        $pos+=5;
        $pdf->Text(30,$pos,'Account Number: 7242568934');
        $pos+=5;
        $pdf->Text(30,$pos,'Bank Address: ');
        $pos+=5;
        $pdf->Text(30,$pos,'38 Fountain Square Plaza');
        $pos+=5;
        $pdf->Text(30,$pos,'Cincinnati, OH 45263');
        $pos+=5;
        $pos+=5;


	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Text(125,32,"Monthly Master Statement");		
	$pdf->SetFont('Times','',12);
	$pdf->Text(10,42,"INFINITI HR CORP");
	$pdf->Text(10,47,"3905 NATIONAL DRIVE");
	$pdf->Text(10,52,"BURTONSVILLE, MD 20866");
	$pos=68;

	$pdf->Text(10,$pos,"COMPANY DETAIL");
	$pos=$pos+10;

        $sql="select * from nua_company_invoice where month_id = '" . $month_id . "' and company_id in (select id from nua_company where org_id = 17) order by company_name";
        $x=$X->sql($sql);

	$pdf->Text(10,$pos,'COMPANY NAME');
	$pdf->Text(120,$pos,'MEDICAL');
	        $pdf->Text(150,$pos,'OTHER');
	        $pdf->Text(175,$pos,'TOTAL');
	$pos=$pos+7;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$last="XXX";
	foreach($x as $d) {
		$other=floatval(str_replace(",","",$d['dental_total']))+floatval(str_replace(",","",$d['vision_total']))+floatval(str_replace(",","",$d['add_total']));
	   $pos+=5;
$sql="select infinity_id from nua_company where id = " . $d['company_id'];
$z=$X->sql($sql);

if ($z[0]['infinity_id']!=substr($d['company_name'],0,4)) {
	$pdf->Text(10,$pos,$z[0]['infinity_id'] . '-' . substr(strtoupper($d['company_name']),0,40));
} else {
	$pdf->Text(10,$pos,substr(strtoupper($d['company_name']),0,30));
}
	   $pdf->Text(125,$pos,"$" . $d['medical_total']);
	   $pdf->Text(150,$pos,"$" . number_format($other,2));	   
	   $pdf->Text(175,$pos,"$" . $d['grand_total']);	   
           if ($pos>275) {
		$pdf->AddPage();
 	        $pdf->SetFont('Arial','B',15);
	        $pdf->Text(125,32,"Monthly Master Statement");		
	        $pdf->SetFont('Times','',12);
	        $pdf->Text(10,42,"INFINITI HR CORP");
	        $pdf->Text(10,47,"3905 NATIONAL DRIVE");
	        $pdf->Text(10,52,"BURTONSVILLE, MD 20866");
	        $pos=68;
		$pdf->Text(10,$pos,"COMPANY DETAIL (CONTINUED)");
		$pos=$pos+10;
	        $pdf->Text(10,$pos,'COMPANY NAME');
	        $pdf->Text(120,$pos,'MEDICAL');
	        $pdf->Text(150,$pos,'OTHER');
	        $pdf->Text(175,$pos,'TOTAL');
		$pos=$pos+7;
		$pdf->SetLineWidth(.50);
		$pdf->Line(10,$pos,200,$pos);			
  	     }
	}

	if ($display=="B" ) {
            // Browser
	    $pdf->Output();
	} 
        if ($display=="S" ) {
            // Force Save to File
	    $pdf->Output('D',$file_name);
        }
	if ($display=="F" ) {
            // Save to Server
	    $pdf->Output('F','/var/www/html/d/' . $file_name);
        }

?>

