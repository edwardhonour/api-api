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
        
        if (!isset($_GET['month_id'])) $_GET['month_id']="2022-04"; 
	if (!isset($_GET['id'])) $_GET['id']="ALL";
        $company_id = $_GET['id'];
        $month_id=$_GET['month_id'];
	$month_id = "2022-05";
	$last_month_id = "2022-04";
	$display = "F";

	$company_id = "ALL";
	$pdf = new PDF();
	$pdf->AliasNbPages();
        if ($company_id=="ALL") {
             $sql="select * from nua_company where org_id = 17 and id > 1 and id <> 5906 order by company_name";
             $file_name="COMPANY_DETAIL" . "_" . $month_id . ".pdf";
	} else {
             $sql="select * from nua_company where org_id = 17 and id = " . $company_id . " order by company_name";
        }
        $list=$X->sql($sql);
	foreach($list as $bbb) {
              
                $company_id = $bbb['id'];
		$sql="select count(*) as c from nua_monthly_member_census where month_id = '" . $month_id . "' and company_id = " . $company_id;
	        $ggg=$X->sql($sql);
		if ($ggg[0]['c']=='0') {

	 	     $sql="delete from nua_company_invoice where month_id = '" . $month_id . "' and company_id = " . $company_id;
		     $X->execute($sql);

		     $sql="update nua_company set invoicing = 'N' where id = " . $company_id;
                     $X->execute($sql);

		} else {	

		     $sql="update nua_company set invoicing = 'N' where id = " . $company_id;
                     $X->execute($sql);

	 	     $sql="select * from nua_company_invoice where month_id = '" . $month_id . "' and company_id = " . $company_id;
                     $inv=$X->sql($sql);

		     $sql="select * from nua_company where id = " . $company_id;
                     $c=$X->sql($sql);
                     $company=$c[0];
                     $output['company']=$company;
                     if ($output!="ALL") {
       		         $file_name=str_replace(" ","_",$company['company_name']);
		         $file_name=str_replace("#","_",$file_name);
                         $file_name=str_replace(",","_",$file_name);
                         $file_name=$file_name . ".pdf";
                     }

                     $post=array();
                     $post['table_name']="nua_company_invoice";
                     $post['action']="insert";

                     if (sizeof($inv)>0) {
                           $post['id']=$inv[0]['id'];
                           $invoice_id=$post['id'];
		     }

                     $post['month_id']=$month_id;
                     $post['company_id']=$company_id;
                     if ($month_id=="2022-01") { $post['billing_date']="12/05/2021"; $post['due_date']="12/31/2021"; }
                     if ($month_id=="2022-02") { $post['billing_date']="01/05/2022"; $post['due_date']="01/31/2022"; }
                     if ($month_id=="2022-03") { $post['billing_date']="02/05/2022"; $post['due_date']="02/28/2022"; }
                     if ($month_id=="2022-04") { $post['billing_date']="03/15/2022"; $post['due_date']="03/31/2022"; }
                     if ($month_id=="2022-05") { $post['billing_date']="04/15/2022"; $post['due_date']="04/29/2022"; }
                     $post['grand_total']=number_format(0, 2);
                     $post['medical_total']=number_format(0, 2);
                     $post['dental_total']=number_format(0, 2);
                     $post['vision_total']=number_format(0, 2);
                     $post['life_total']=number_format(0, 2);
                     $post['add_total']=number_format(0, 2);
                     $post['adjustment_total']=number_format(0, 2);
                     $post['company_name']=$company['company_name'];
                     $post['contact_name']=$company['invoice_contact_name'];
                     if ($company['invoice_mailing_address']!='') {
                             $post['billing_address']=$company['invoice_mailing_address'];
                     } else {
                             $post['billing_address']=$company['address'];
                     }
                     if ($company['invoice_city']!='') {
                             $post['billing_city']=$company['invoice_city'];
                     } else {
                             $post['billing_city']=$company['city'];
                     }
                     if ($company['invoice_state']!='') {
                             $post['billing_state']=$company['invoice_state'];
                     } else {
                             $post['billing_state']=$company['state'];
                     }
                     if ($company['invoice_zip']!='') {
                             $post['billing_zip']=$company['invoice_zip'];
                     } else {
                             $post['billing_zip']=$company['zip'];
                     }
                     $post['billing_email']="";
                     $post['billing_cc_email']="";
		     $invoice_id=$X->post($post);
		     
		     //--
		     // CREATE THE INVOICE NUMBER 
		     //--

		     $sql="update nua_company_invoice set invoice_number = '";
                     $sql .= $company_id . '-' . $month_id . "' where id = " . $invoice_id;
                     $X->execute($sql);

                            $medical_total=0;
                            $dental_total=0;
                            $vision_total=0;
                            $add_total=0;

                     $sql="select * from nua_company_plan where company_id = " . $company_id . " order by invoice_order, plan_code";
                     $plans=$X->sql($sql);
                     $grand_total=0;
                     $sub_total=0;
		     $adj_total=0;

                     $ee_grand_count=0;
                     $eec_grand_count=0;
                     $ees_grand_count=0;
		     $fam_grand_count=0;
                     $total_grand_count=0;
                     $ee_grand_total=0;
                     $eec_grand_total=0;
                     $ees_grand_total=0;
		     $fam_grand_total=0;
                     $total_grand_total=0;
                     $sql="delete from nua_company_invoice_detail where invoice_id = " . $invoice_id;
                     $X->execute($sql);
                     foreach ($plans as $p) {
                            $ee_total=0;
                            $eec_total=0;
                            $ees_total=0;
                            $fam_total=0;
                            $ee_count=0;
                            $ees_count=0;
                            $eec_count=0;
                            $fam_count=0;
			    $sql="select * from nua_monthly_member_census where dependent_code = '' and ";
                            $sql.="  company_id = " . $company_id . " and month_id = '" . $month_id . "' ";
                            $sql.="  and billed_month_id = '" . $month_id . "' and coverage_price <> '' and eff_dt <> term_dt and client_plan = '" . $p['plan_code'] . "'";
                            $cc=$X->sql($sql);
                            foreach($cc as $c) {
                                   $grand_total+=floatval($c['coverage_price']);
                                   if ($p['plan_type']=="*DENTAL*") { $dental_total+=floatval($c['coverage_price']); }
                                   if ($p['plan_type']=="*VISION*") { $vision_total+=floatval($c['coverage_price']); }
                                   if ($p['plan_type']=="*ADD*") { $add_total+=floatval($c['coverage_price']); }
                                   if ($p['plan_type']=="*LIFE*") { $add_total+=floatval($c['coverage_price']); }
				   if ($c['coverage_level']=="") $c['coverage_level']="EE";
				   if ($c['coverage_level']=="EE"||$c['coverage_level']=="SI") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['ee_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $ee_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $ee_count++;
                                          if ($p['plan_type']=="*MEDICAL*") {
                                             $ee_grand_count++;
					     $total_grand_count++;
					     $ee_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                          }
                                   }
				   if ($c['coverage_level']=="EC"||$c['coverage_level']=="EC2") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['eec_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $eec_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $eec_count++;
                                          if ($p['plan_type']=="*MEDICAL*") {
                                             $eec_grand_count++;
                                             $total_grand_count++;
					     $eec_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                          }
                                   }
				   if ($c['coverage_level']=="ES"||$c['coverage_level']=="ES") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['ees_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $ees_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $ees_count++;
                                          if ($p['plan_type']=="*MEDICAL*") {
                                             $ees_grand_count++;
                                             $total_grand_count++;
					     $ees_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                          }
                                   }
				   if ($c['coverage_level']=="FA"||$c['coverage_level']=="FAM") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['fam_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $fam_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $fam_count++;
                                          if ($p['plan_type']=="*MEDICAL*") {
                                             $fam_grand_count++;
                                             $total_grand_count++;
					     $fam_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                          }
                                   }


                            }
                            $post=array();
                            $post['table_name']="nua_company_invoice_detail";
                            $post['action']="insert";
			    $sql="select * from nua_company_invoice_detail where invoice_id = " . $invoice_id . " and plan_code = '" . $p['plan_code'] . "'";
                            $pp=$X->sql($sql); 
                            if (sizeof($pp)>0) {
                                $post['id']=$pp[0]['id'];
			    }

                            $post['invoice_id']=$invoice_id;
                            $post['plan_code']=$p['plan_code'];
                            $post['plan_type']=$p['plan_type'];
                            $post['company_id']=$company_id;

                            $post['apa_code']=$p['APA_CODE'];
                            $post['ee_price']=number_format(floatval($p['ee_price']), 2);
                            $post['ee_qty']=$ee_count;
                            $post['ee_total']=number_format($ee_total,2);
                            $post['ees_price']=number_format(floatval($p['ees_price']),2);
                            $post['ees_qty']=$ees_count;
                            $post['ees_total']=number_format($ees_total,2);
                            $post['eec_price']=number_format(floatval($p['eec_price']),2);
                            $post['eec_qty']=$eec_count;
                            $post['eec_total']=number_format($eec_total,2);
                            $post['fam_price']=number_format(floatval($p['fam_price']),2);
                            $post['fam_qty']=$fam_count;
                            $post['fam_total']=number_format(floatval($fam_total),2);
                            $X->post($post);
		     }

		     //--
		     //-- Unbilled Medical
		     //--
                $prev_qty=0;
		$prev_total=0;
		$ee_total=0;
		$ee_count=0;
		$ees_total=0;
		$ees_count=0;
		$eec_total=0;
		$eec_count=0;
		$fam_total=0;
		$fam_count=0;
                $sql="select count(*) as c from nua_monthly_member_census where company_id = " . $company_id . " and billed_month_id = '" . $month_id . "' and month_id <> billed_month_id and ";
		$sql.="plan_type = '*MEDICAL*'";
                $a=$X->sql($sql);
		if ($a[0]['c']!='0') {

			    $sql="select * from nua_monthly_member_census where dependent_code = '' and ";
                            $sql.="  company_id = " . $company_id . " and month_id <> billed_month_id ";
                            $sql.="  and billed_month_id = '" . $month_id . "' and coverage_price <> '' and eff_dt <> term_dt and plan_type = '*MEDICAL*'";
                            $cc=$X->sql($sql);
                            foreach($cc as $c) {
                                   $grand_total+=floatval($c['coverage_price']);
                                   $prev_qty++;
                                   $prev_total+=floatval($c['coverage_price']);
                                   $ee_total+=floatval($c['coverage_price']);
				   /*
				   if ($c['coverage_level']=="") $c['coverage_level']="EE";
				   if ($c['coverage_level']=="EE"||$c['coverage_level']=="SI") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['ee_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $ee_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $ee_count++;
                                             $ee_grand_count++;
					     $total_grand_count++;
					     $ee_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                   }
				   if ($c['coverage_level']=="EC"||$c['coverage_level']=="EC2") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['eec_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $eec_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $eec_count++;
                                             $eec_grand_count++;
                                             $total_grand_count++;
					     $eec_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                   }
				   if ($c['coverage_level']=="ES"||$c['coverage_level']=="ES") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['ees_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $ees_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $ees_count++;
                                             $ees_grand_count++;
                                             $total_grand_count++;
					     $ees_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                   }
				   if ($c['coverage_level']=="FA"||$c['coverage_level']=="FAM") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['fam_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $fam_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $fam_count++;
                                             $fam_grand_count++;
                                             $total_grand_count++;
					     $fam_grand_total+=floatval($c['coverage_price']);
					     $total_grand_total+=floatval($c['coverage_price']);
                                   }
				    */

                            }
                            $post=array();
                            $post['table_name']="nua_company_invoice_detail";
                            $post['action']="insert";
			    $sql="select * from nua_company_invoice_detail where invoice_id = " . $invoice_id . " and plan_code = '*APR-MEDICAL'";
                            $pp=$X->sql($sql); 
                            if (sizeof($pp)>0) {
                                $post['id']=$pp[0]['id'];
			    }

                            $post['invoice_id']=$invoice_id;
                            $post['plan_code']='*APR-MEDICAL';
                            $post['plan_type']='*APA*';
                            $post['company_id']=$company_id;

                            $post['apa_code']='XXX';
			    $post['ee_price']="***";
                            $post['ee_qty']=$ee_count;
                            $post['ee_total']=number_format($ee_total,2);
                            $post['ees_price']="***";
                            $post['ees_qty']=$ees_count;
                            $post['ees_total']=number_format($ees_total,2);
                            $post['eec_price']="***";
                            $post['eec_qty']=$eec_count;
                            $post['eec_total']=number_format($eec_total,2);
                            $post['fam_price']="***";
                            $post['fam_qty']=$fam_count;
                            $post['fam_total']=number_format(floatval($fam_total),2);
                            $X->post($post);
		}
		$ee_total=0;
		$ee_count=0;
		$ees_total=0;
		$ees_count=0;
		$eec_total=0;
		$eec_count=0;
		$fam_total=0;
		$fam_count=0;
                $sql="select count(*) as c from nua_monthly_member_census where company_id = " . $company_id . " and billed_month_id = '" . $month_id . "' and month_id <> billed_month_id and ";
		$sql.="plan_type not in ('*MEDICAL*')";
                $a=$X->sql($sql);
		$flag="N";
		if ($a[0]['c']!='0') {

			    $sql="select * from nua_monthly_member_census where dependent_code = '' and ";
                            $sql.="  company_id = " . $company_id . " and month_id <> billed_month_id ";
                            $sql.="  and billed_month_id = '" . $month_id . "' and coverage_price <> '' and eff_dt <> term_dt and plan_type not in ('*MEDICAL*')";
                            $cc=$X->sql($sql);
                            foreach($cc as $c) {
				   $flag="Y";
                                   $grand_total+=floatval($c['coverage_price']);
                                   $prev_qty++;
                                   $prev_total+=floatval($c['coverage_price']);
                                   $ee_total+=floatval($c['coverage_price']);
				   /*
				   if ($c['coverage_level']=="") $c['coverage_level']="EE";
				   if ($c['coverage_level']=="EE"||$c['coverage_level']=="SI") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['ee_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $ee_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $ee_count++;
                                   }
				   if ($c['coverage_level']=="EC"||$c['coverage_level']=="EC2") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['eec_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $eec_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $eec_count++;
                                   }
				   if ($c['coverage_level']=="ES"||$c['coverage_level']=="ES") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['ees_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $ees_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $ees_count++;
                                   }
				   if ($c['coverage_level']=="FA"||$c['coverage_level']=="FAM") {
                                          if ($c['coverage_price']=="") $c['coverage_price'] = $p['fam_price'];
                                          if ($c['coverage_price']=="") $c['coverage_price'] = "0";
                                          $fam_total+=floatval($c['coverage_price']);
                                          $sub_total+=floatval($c['coverage_price']);
                                          $fam_count++;
                                   }
				    */

                            }
                            $post=array();
                            $post['table_name']="nua_company_invoice_detail";
                            $post['action']="insert";
			    $sql="select * from nua_company_invoice_detail where invoice_id = " . $invoice_id . " and plan_code = '*APR-GUARDIAN'";
                            $pp=$X->sql($sql); 
                            if (sizeof($pp)>0) {
                                $post['id']=$pp[0]['id'];
			    }

                            $post['invoice_id']=$invoice_id;
                            $post['plan_code']='*APR-GUARDIAN';
                            $post['plan_type']='*GUARDIAN*';
                            $post['company_id']=$company_id;

                            $post['apa_code']='XXX';
                            $post['ee_price']="***";
                            $post['ee_qty']=$ee_count;
                            $post['ee_total']=number_format($ee_total,2);
                            $post['ees_price']="***";
                            $post['ees_qty']=$ees_count;
                            $post['ees_total']=number_format($ees_total,2);
                            $post['eec_price']="***";
                            $post['eec_qty']=$eec_count;
                            $post['eec_total']=number_format($eec_total,2);
                            $post['fam_price']="***";
                            $post['fam_qty']=$fam_count;
                            $post['fam_total']=number_format(floatval($fam_total),2);
                            $X->post($post);

		}

                $grand_total=0;
		$sql="select * from nua_company_invoice_detail where invoice_id = " . $invoice_id;
		$a=$X->sql($sql);
                foreach($a as $b) {
	             $f_ee=str_replace("$","",$b['ee_total']);
	             $f_ee=str_replace(",","",$f_ee);
	             $f_ees=str_replace("$","",$b['ees_total']);
	             $f_ees=str_replace(",","",$f_ees);
	             $f_eec=str_replace("$","",$b['eec_total']);
	             $f_eec=str_replace(",","",$f_eec);
	             $f_fam=str_replace("$","",$b['fam_total']);
	             $f_fam=str_replace(",","",$f_fam);
		     $grand_total+=floatval($f_ee)+floatval($f_eec)+floatval($f_ees)+floatval($f_fam);
		}


                $sql="select amount from nua_company_invoice_adjustments where company_id = " . $company_id . " and month_id = '" . $month_id . "'";
                $a=$X->sql($sql);
                foreach($a as $b) {
                     $adj_total+=floatval($b['amount']);
		}
                $grand_total=$grand_total+$adj_total;
                $post=array();
                $post['table_name']="nua_company_invoice";
                $post['action']="insert";
                $post['id']=$invoice_id;
                $post['dental_total']=number_format($dental_total,2);
                $post['vision_total']=number_format($vision_total,2);
                $post['add_total']=number_format($add_total,2);

		$post['ee_medical_count']=$ee_grand_count;
		$post['ee_medical_total']=$ee_grand_total;
		$post['eec_medical_count']=$eec_grand_count;
		$post['eec_medical_total']=$eec_grand_total;
		$post['ees_medical_count']=$ees_grand_count;
		$post['ees_medical_total']=$ees_grand_total;
		$post['fam_medical_count']=$fam_grand_count;
		$post['fam_medical_total']=$fam_grand_total;
		$post['medical_count']=$total_grand_count;
		$post['medical_total']=number_format($total_grand_total,2);

                $post['grand_total']=number_format($grand_total,2); 
                $post['grand_total_float']=$grand_total; 
                $post['adjustments']=number_format($adj_total,2); 
                $post['sub_total']=number_format($sub_total,2); 
		$post['prev_qty']=$prev_qty;
		$post['prev_total']=$prev_total;
                $X->post($post);
                $po=array();
                $po['table_name']="nua_company";
                $po['action']="insert";
                $po['id']=$company_id;
		$po['grand_total_float']=$grand_total;
		$po['grand_total_count']=$total_grand_count;
		$X->post($po);


	$sql="select * from nua_company where id = " . $company_id;
	$co=$X->sql($sql);
	$company=$co[0];
	$company_name=$company['company_name'];

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
//		if ($p0['ee_qty']>0||$p0['eec_qty']>0||$p0['ees_qty']>0||$p0['fam_qty']>0) {
		   array_push($detail,$p0);
//		}
	}

	$sql="select * from nua_monthly_member_census where company_id = " . $company_id . " and month_id = '" . $month_id . "' ";
        $sql.=" and billed_month_id = '" . $month_id . "' and eff_dt <> term_dt and dependent_code = '' order by last_name, first_name";
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
	   if ($p0['plan_type']=="*MEDICAL*") $count++;
	}

	$sql="select * from nua_monthly_member_census where company_id = " . $company_id . " and month_id <> '" . $month_id . "' ";
        $sql.=" and billed_month_id = '" . $month_id . "' and eff_dt <> term_dt and dependent_code = '' order by last_name, first_name";
	$enrollments_pre=array();
	$p00=$X->sql($sql);
	$count=0;
	foreach($p00 as $p0) {
	   array_push($enrollments_pre,$p0);
	}

        $invite_total_float=0;
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Text(125,32,"Monthly Statement");		
	$pdf->SetFont('Times','',10);
	$pdf->Text(10,42,$invoice['company_name']);
	$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
	$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
	$pos=57;
/*	   if ($company['billing_contact_phone']!="") {
		   $pdf->Text(10,$pos,$company['billing_contact_phone']);
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
 */	   
	$pdf->Text(120,42,'Invoice Number:');
	$pdf->Text(120,47,'Invoice Month:');
	$pdf->Text(120,52,'Billing Date:');
	$pdf->Text(120,57,'Payment Due Date:');

	$pdf->Text(180,42,$invoice['invoice_number']);
	$pdf->Text(180,47,'MAY');
	$pdf->Text(180,52,'04/15/2022');
	$pdf->Text(180,57,'04/29/2022');

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
	                                $pdf->SetFont('Times','',10);
					if ($d['ee_qty']!="0") {
							$pos+=5;
							$pdf->Text(10,$pos,substr(strtoupper($d['plan_code']),0,18));
                 					$pdf->Text(50,$pos,"Employee Only");
							$pdf->Text(105,$pos,$d['ee_qty']);
							if ($d['plan_code']!="LIFE"&&$d['plan_code']!="ADD") {
								$pdf->Text(135,$pos,"$" . $d['ee_price']);
							} else {
								$pdf->Text(135,$pos,"$" . $d['ee_price'] . '**');
							}
							$pdf->Text(175,$pos,"$" . $d['ee_total']);
							$line_count++;
					}
					if ($d['ees_qty']!="0") {
							$pos+=5;
							$pdf->Text(10,$pos,substr(strtoupper($d['plan_code']),0,18));
						$pdf->Text(50,$pos,"Employee & Spouse Only");
							$pdf->Text(105,$pos,$d['ees_qty']);
							$pdf->Text(135,$pos,"$" . $d['ees_price']);
							$pdf->Text(175,$pos,"$" . $d['ees_total']);
													$line_count++;
					}
					if ($d['eec_qty']!="0") {
							$pos+=5;
							$pdf->Text(10,$pos,substr(strtoupper($d['plan_code']),0,18));
						$pdf->Text(50,$pos,"Employee & Children");
							$pdf->Text(105,$pos,$d['eec_qty']);
							$pdf->Text(135,$pos,"$" . $d['eec_price']);
							$pdf->Text(175,$pos,"$" . $d['eec_total']);
				            $line_count++;
					}
					if ($d['fam_qty']!="0") {
							$pos+=5;
							$pdf->Text(10,$pos,substr(strtoupper($d['plan_code']),0,18));
							$pdf->Text(50,$pos,"Family");
							$pdf->Text(105,$pos,$d['fam_qty']);
							$pdf->Text(135,$pos,"$" . $d['fam_price']);
							$pdf->Text(175,$pos,"$" . $d['fam_total']);
							$line_count++;
					}
	   }
	$pos=$pos+5;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$pos+=5;
	$pdf->Text(135,$pos,'GRAND TOTAL');
	$pdf->Text(175,$pos,"$" . $invoice['grand_total']);

	$pos=135+($line_count*7);

//	if ($pos>245) { 
//		$pos=245;
//	}
//	$pdf->Text(30,$pos,'** Prices vary in PRISM. ');
//	$pos+=5;
//	$pdf->Text(30,$pos,'Individual prices shown in census.');
//	$pos+=5;

	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->Text(10,42,$invoice['company_name']);
	$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
	$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
	$pos=68;

	$pdf->Text(10,$pos,"CURRENT MONTH ENROLLMENT");
	$pos=$pos+10;

	$pdf->SetFont('Times','',10);
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
	                                $pdf->SetFont('Times','',10);
			if ($d['last_name'] . ', ' . $d['first_name']!=$last&&$last!="XXX") {
			   $pos+=9;
			} else {
			   $pos+=5;	
			}
			$last=$d['last_name'] . ', ' . $d['first_name'];
			$pdf->Text(10,$pos,strtoupper($d['last_name']) . ', ' . strtoupper($d['first_name']));
			$pdf->Text(75,$pos, $d['eff_dt']);
			$pdf->Text(105,$pos,substr(strtoupper($d['client_plan']),0,18));
			$pdf->Text(145,$pos,$d['coverage_level']);
			$pdf->Text(175,$pos,"$" . $d['coverage_price']);	   

			if ($pos>250) {
				$pdf->AddPage();
				$pdf->SetFont('Times','',10);
				$pdf->Text(10,42,$invoice['company_name']);
				$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
				$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
				$pos=77;

				$pdf->Text(10,$pos,"CURRENT MONTH ENROLLMENT (CONTINUED)");
				$pos=$pos+10;

				$pdf->SetFont('Times','',10);
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

	   if (sizeof($enrollments_pre)>0) {

	$pdf->AddPage();
	$pdf->SetFont('Times','',10);
	$pdf->Text(10,42,$invoice['company_name']);
	$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
	$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
	$pos=68;

	$pdf->Text(10,$pos,"PRIOR MONTH UNBILLED ENROLLMENT");
	$pos=$pos+10;

	$pdf->SetFont('Times','',10);
	$pdf->Text(10,$pos,'MEMBER NAME');
	$pdf->Text(75,$pos,'EFF DATE');
	$pdf->Text(105,$pos,'PLAN');
	$pdf->Text(145,$pos,'COVERAGE');
	$pdf->Text(175,$pos,'PRICE');
	$pos=$pos+7;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);
	$last="XXX";
	   foreach($enrollments_pre as $d) {
	                                $pdf->SetFont('Times','',10);
			if ($d['last_name'] . ', ' . $d['first_name']!=$last&&$last!="XXX") {
			   $pos+=9;
			} else {
			   $pos+=5;	
			}
			$last=$d['last_name'] . ', ' . $d['first_name'];
			$pdf->Text(10,$pos,strtoupper($d['last_name']) . ', ' . strtoupper($d['first_name']));
			$pdf->Text(75,$pos, $d['eff_dt']);
			$pdf->Text(105,$pos,substr(strtoupper($d['client_plan']),0,18));
			$pdf->Text(145,$pos,$d['coverage_level']);
			$pdf->Text(175,$pos,"$" . $d['coverage_price']);	   

			if ($pos>250) {
				$pdf->AddPage();
				$pdf->SetFont('Times','',10);
				$pdf->Text(10,42,$invoice['company_name']);
				$pdf->Text(10,47,$invoice['billing_address'] . ' ' . $company['invoice_suite']);
				$pdf->Text(10,52,$invoice['billing_city'] . ', ' . $invoice['billing_state'] . ' ' . $invoice['billing_zip']);
				$pos=77;

				$pdf->Text(10,$pos,"PRIOR MONTH UNBILLED ENROLLMENT (CONTINUED)");
				$pos=$pos+10;

				$pdf->SetFont('Times','',10);
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

	   }


	$pos=$pos+3;
	$pdf->SetLineWidth(.50);
	$pdf->Line(10,$pos,200,$pos);   
	$pos=$pos+15;
	$pdf->Text(130,$pos,"MEDICAL PLAN COUNTS");
	$pos+=5;
	$pdf->Text(130,$pos,'Employee Only');
	$pdf->Text(175,$pos,$ee);
	$pos+=5;
	$pdf->Text(130,$pos,'Employee & Spouse');
	$pdf->Text(175,$pos,$es);
	$pos+=5;
	$pdf->Text(130,$pos,'Employee & Children');
	$pdf->Text(175,$pos,$ec);						
	$pos+=5;
	$pdf->Text(130,$pos,'Family');
	$pdf->Text(175,$pos,$fam);	

	}
     
       } // list of companies being processed, usually 1.
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

