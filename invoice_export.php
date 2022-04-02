<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Content-type: application/json');
require_once('/var/www/classes/class.XRDB.php');
$X=new XRDB();

$company_id = $_GET['id'];
$month_id = "2022-04";

$sql="select * from nua_company where id = " . $company_id;
$co=$X->sql($sql);
$company=$co[0];
$company_name=$company['company_name'];
$file_name=str_replace(" ","_",$company_name) . "_" . $month_id . ".xml";

$sql="select * from nua_company_invoice where month_id = '" . $month_id . "' and company_id = " . $company_id;
$inv=$X->sql($sql);
$invoice_id=$inv[0]['id'];
foreach($inv[0] as $name => $value) {
     $output[$name]=$value;
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
       if ($p0['coverage_level']=='EE') $ee++;
       if ($p0['coverage_level']=='EC') $es++;
       if ($p0['coverage_level']=='ES') $es++;
       if ($p0['coverage_level']=='FAM') $fam++;	   
	   $count++;
}

//------------------------------------------------------------------------
// Headers
//------------------------------------------------------------------------ 

header('Content-type: application/xml');
header("Content-Disposition: attachment; filename=" . $file_name);

$book='<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Nanette</Author>
  <LastAuthor>Edward Honour</LastAuthor>
  <Created>2019-12-14T17:19:33Z</Created>
  <LastSaved>2022-03-15T15:27:00Z</LastSaved>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>11985</WindowHeight>
  <WindowWidth>28800</WindowWidth>
  <WindowTopX>32767</WindowTopX>
  <WindowTopY>32767</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="m1865285573284">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="m1830727606680">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="m1830727606700">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="m1830727606720">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="m1830727606740">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s62">
   <Alignment ss:Vertical="Bottom"/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s63">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s65">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s67">
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s68">
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#0066CC"/>
  </Style>
  <Style ss:ID="s71">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s72">
   <Alignment ss:Vertical="Bottom"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#0066CC"/>
  </Style>
  <Style ss:ID="s73">
   <Alignment ss:Vertical="Bottom"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s74">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s75">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
   <NumberFormat ss:Format="mm/dd/yyyy"/>
  </Style>
  <Style ss:ID="s76">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#FF0000"/>
   <NumberFormat ss:Format="mm/dd/yyyy"/>
  </Style>
  <Style ss:ID="s83">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s84">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s85">
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s86">
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s87">
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s88">
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s89">
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s92">
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
   <NumberFormat ss:Format="&quot;$&quot;#,##0.00"/>
  </Style>
  <Style ss:ID="s93">
   <Alignment ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
   <NumberFormat ss:Format="&quot;$&quot;#,##0.00"/>
  </Style>
  <Style ss:ID="s94">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s95">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s96">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s97">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s98">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s99">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
   <NumberFormat ss:Format="&quot;$&quot;#,##0.00"/>
  </Style>
  <Style ss:ID="s101">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#FF0000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s103">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Underline="Single"/>
  </Style>
  <Style ss:ID="s105">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="8" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s107">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s109">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Underline="Single"/>
  </Style>
  <Style ss:ID="s111">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Underline="Single"/>
  </Style>
  <Style ss:ID="s112">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s114">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
   <Style ss:ID="s138">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
   <NumberFormat ss:Format="@"/>
  </Style>
   <Style ss:ID="s140">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s143">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="Double" ss:Weight="3"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s146">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s155">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Balthazar" ss:Size="14" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s156">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Balthazar" ss:Size="11" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s158">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="12"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s159">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
   <Interior ss:Color="#D8D8D8" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s160">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
   <Interior ss:Color="#D8D8D8" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="mm/dd/yy"/>
  </Style>
  <Style ss:ID="s161">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
   <Interior ss:Color="#D8D8D8" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s162">
   <Alignment ss:Vertical="Top"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s163">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s164">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s165">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s166">
   <Alignment ss:Vertical="Top"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Book Antiqua" x:Family="Roman" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s167">
   <Alignment ss:Vertical="Top"/>
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="8"
    ss:Color="#000000"/>
  </Style>
 </Styles>';
 
 $book.='<Worksheet ss:Name="Grand Total">
  <Table ss:ExpandedColumnCount="26" ss:ExpandedRowCount="1000" x:FullColumns="1"
   x:FullRows="1" ss:StyleID="s62" ss:DefaultColumnWidth="75.75"
   ss:DefaultRowHeight="15">
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="56.25"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="105.75"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="66.75"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="56.25" ss:Span="1"/>
   <Column ss:Index="6" ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="66.75"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="98.25"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="45.75" ss:Span="18"/>
   <Row ss:AutoFitHeight="0"/>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:StyleID="s63"/>
    <Cell ss:Index="6" ss:MergeAcross="1" ss:StyleID="s65"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="2" ss:StyleID="s67"><Data ss:Type="String">Bill To:</Data></Cell>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>';
   
   if ($company['billing_contact_email']!="") {
	   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
	   $book.='<Cell ss:Index="2" ss:StyleID="s68"><Data ss:Type="String">' . $company['billing_contact_email'] . '</Data></Cell>';
	   $book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s71"><Data ss:Type="String">Monthly Billing</Data></Cell></Row>';
   }

   if ($company['billing_contact_email2']!="") {
	   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
	   $book.='<Cell ss:Index="2" ss:StyleID="s68"><Data ss:Type="String">' . $company['billing_contact_email2'] . '</Data></Cell>';
	   $book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/></Row>';
   }

   if ($company['billing_contact_email3']!="") {
	   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
	   $book.='<Cell ss:Index="2" ss:StyleID="s68"><Data ss:Type="String">' . $company['billing_contact_email3'] . '</Data></Cell>';
	   $book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/></Row>';
   }   
   
   if ($company['billing_contact_email4']!="") {
	   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
	   $book.='<Cell ss:Index="2" ss:StyleID="s68"><Data ss:Type="String">' . $company['billing_contact_email4'] . '</Data></Cell>';
	   $book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/></Row>';
   }
   if ($company['billing_contact_email5']!="") {
	   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
	   $book.='<Cell ss:Index="2" ss:StyleID="s68"><Data ss:Type="String">' . $company['billing_contact_email5'] . '</Data></Cell>';
	   $book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/></Row>';
   }
//	$book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
//	$book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/></Row>';   

   if ($company['company_name']!="") {
	   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
	   $book.='<Cell ss:Index="2" ss:StyleID="s68"><Data ss:Type="String">' . $company['company_name'] . '</Data></Cell>';
	   $book.='<Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/><Cell ss:StyleID="s67"/></Row>';
   }
   if ($company['address']!=""||$output['invoice_number']!="") {
	   if ($company['address']=='') $company['address']='.';
	   if ($output['invoice_number']=='') $output['invoice_number']='.';
       $book.='   <Row ss:AutoFitHeight="0" ss:Height="16.5"> ';
       $book.=' <Cell ss:Index="2" ss:StyleID="s73"><Data ss:Type="String">' . $company['address'] . '</Data></Cell>';
       $book.='    <Cell ss:StyleID="s67"/>';
       $book.='    <Cell ss:StyleID="s67"/>';
       $book.='    <Cell ss:MergeAcross="1" ss:StyleID="s65"><Data ss:Type="String">Invoice Number</Data></Cell>';
       $book.='    <Cell ss:StyleID="s74"><Data ss:Type="String">' . $output['invoice_number'] . '</Data></Cell>';
       $book.='  </Row>';
   }

   if ($company['invoice_suite']=='') $company['invoice_suite']=" ";
   if ($output['month_id']=='2022-04') $output['month']="APRIL";
   
   
   $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
   $book.='    <Cell ss:Index="2"><Data ss:Type="String">' . $company['invoice_suite'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"/>';
   $book.='    <Cell ss:StyleID="s67"/>';
   $book.='    <Cell ss:MergeAcross="1" ss:StyleID="s65"><Data ss:Type="String">Month For</Data></Cell>';
   $book.='    <Cell ss:StyleID="s74"><Data ss:Type="String">' . $output['month'] . '</Data></Cell>';
   $book.='   </Row>';

   if ($output['billing_city']=='') $output['billing_city']=" ";
   if ($output['billing_state']=='') $output['billing_state']=" ";
   if ($output['billing_zip']=='') $output['billing_zip']=" ";
   if ($company['invoice_contact_phone']=='') $company['billing_contact_phone']=" ";
   
   $book.='   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="2" ss:StyleID="s73"><Data ss:Type="String">' . $output['billing_city'] . ', ' . $output['billing_state'] . ' ' . $output['billing_zip'] . ' </Data></Cell>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:MergeAcross="1" ss:StyleID="s65"><Data ss:Type="String">Billing Date</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="DateTime">2022-03-15T00:00:00.000</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="2" ss:StyleID="s67"><Data ss:Type="String">' . $company['billing_contact_phone'] . '</Data></Cell>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:MergeAcross="1" ss:StyleID="s65"><Data ss:Type="String">Payment is Due By</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="DateTime">2022-04-01T00:00:00.000</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="2" ss:StyleID="s67"><Data ss:Type="String">Broker: </Data></Cell>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="49.5">
    <Cell ss:Index="2" ss:MergeAcross="1" ss:StyleID="m1865285573284"><Data
      ss:Type="String">Plan</Data></Cell>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s83"><Data ss:Type="String">Coverage</Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="String">Plans</Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="String">Amount</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="6.75">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="2" ss:StyleID="s85"/>
    <Cell ss:StyleID="s86"/>
    <Cell ss:StyleID="s86"/>
    <Cell ss:StyleID="s86"/>
    <Cell ss:StyleID="s86"/>
    <Cell ss:StyleID="s87"/>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="2" ss:StyleID="s88"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s89"/>
   </Row>';

    foreach($detail as $d) {
		if ($d['ee_qty']!="0") {
   $book.='    <Row ss:AutoFitHeight="0">';
   $book.='    <Cell ss:Index="2" ss:StyleID="s88"><Data ss:Type="String">' . $d['plan_code'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"/>';
   $book.='    <Cell ss:StyleID="s140"><Data ss:Type="String">EE</Data></Cell>';
   $book.='    <Cell ss:StyleID="s138"><Data ss:Type="String">' . $d['ee_price'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"><Data ss:Type="Number">' . $d['ee_qty'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s143"><Data ss:Type="String">$' . $d['ee_total'] . '</Data></Cell>';
   $book.='   </Row>';
		}
		if ($d['ees_qty']!="0") {
   $book.='    <Row ss:AutoFitHeight="0">';
   $book.='    <Cell ss:Index="2" ss:StyleID="s88"><Data ss:Type="String">' . $d['plan_code'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"/>';
   $book.='    <Cell ss:StyleID="s140"><Data ss:Type="String">ES</Data></Cell>';
   $book.='    <Cell ss:StyleID="s138"><Data ss:Type="String">' . $d['ees_price'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"><Data ss:Type="Number">' . $d['ees_qty'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s143"><Data ss:Type="String">$' . $d['ees_total'] . '</Data></Cell>';
   $book.='   </Row>';
		}		
		if ($d['eec_qty']!="0") {
   $book.='    <Row ss:AutoFitHeight="0">';
   $book.='    <Cell ss:Index="2" ss:StyleID="s88"><Data ss:Type="String">' . $d['plan_code'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"/>';
   $book.='    <Cell ss:StyleID="s140"><Data ss:Type="String">EC</Data></Cell>';
   $book.='    <Cell ss:StyleID="s138"><Data ss:Type="String">' . $d['eec_price'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"><Data ss:Type="Number">' . $d['eec_qty'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s143"><Data ss:Type="String">$' . $d['eec_total'] . '</Data></Cell>';
   $book.='   </Row>';
		}	
		if ($d['fam_qty']!="0") {
   $book.='    <Row ss:AutoFitHeight="0">';
   $book.='    <Cell ss:Index="2" ss:StyleID="s88"><Data ss:Type="String">' . $d['plan_code'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"/>';
   $book.='    <Cell ss:StyleID="s140"><Data ss:Type="String">FAM</Data></Cell>';
   $book.='    <Cell ss:StyleID="s138"><Data ss:Type="String">$' . $d['fam_price'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s67"><Data ss:Type="Number">' . $d['fam_qty'] . '</Data></Cell>';
   $book.='    <Cell ss:StyleID="s143"><Data ss:Type="String">$' . $d['fam_total'] . '</Data></Cell>';
   $book.='   </Row>';
		}	
		
		
   }
   
   $book.='<Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s88"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s89"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s94"/>
    <Cell ss:StyleID="s95"/>
    <Cell ss:StyleID="s95"/>
    <Cell ss:StyleID="s95"/>
    <Cell ss:StyleID="s95"/>
    <Cell ss:StyleID="s96"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="6.75">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s97"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s98"><Data ss:Type="String">Grand Total </Data></Cell>
    <Cell ss:StyleID="s143"><Data ss:Type="String">$' . $output['grand_total'] . '</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="2" ss:MergeAcross="5" ss:MergeDown="4" ss:StyleID="s101"><Data
      ss:Type="String">Effective on January 1, 2020, a 1% fee will be assessed to the balance of any outstanding invoice amount that is not received by the due date, 1st of every month.  Please note, the plan has a 30 day grace period. If the premium has not been received by the end of the month of the due date, your cancellation will take effect on the last day of the month premium was fully paid.</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0"/>
   <Row ss:AutoFitHeight="0" ss:Height="15.75" ss:Span="2"/>
   <Row ss:Index="36" ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="5" ss:StyleID="s103"><Data ss:Type="String">Payment:</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="32.25">
    <Cell ss:Index="2" ss:MergeAcross="5" ss:StyleID="s105"><Data ss:Type="String">To avoid any insurance interruption or suspension, please remit all payments per the below payment instructions</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="5" ss:StyleID="s107"><Data ss:Type="String">ACH IS THE PREFERRED METHOD OF PAYMENT</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="2" ss:StyleID="s109"><Data ss:Type="String">Deposit at the Bank:</Data></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="s111"><Data ss:Type="String">ACH &amp; Wire Instructions:</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="2" ss:StyleID="s112"><Data ss:Type="String">Account Name: NuAxess</Data></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">Account Name: NuAxess 2 Inc.</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="2" ss:StyleID="s112"><Data ss:Type="String">Bank: Bank of America</Data></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">Bank: Bank of America</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="2" ss:StyleID="s112"><Data ss:Type="String">Account Number: 325130832674</Data></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">ACH Routing Number (Paper/Electronic):</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:StyleID="s114"/>
    <Cell ss:MergeAcross="1" ss:StyleID="s114"><Data ss:Type="String">122000661/121000358</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">Wire Routing Number: 026009593</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:MergeAcross="2" ss:StyleID="s112"/>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">Account Number: 325130832674</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">Bank Address: 287 26th St.</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:StyleID="s112"/>
    <Cell ss:MergeAcross="2" ss:StyleID="s114"><Data ss:Type="String">Santa Monica, CA 90402</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75" ss:Span="951"/>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0"/>
    <Footer x:Margin="0"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <FitToPage/>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>2</ActiveRow>
     <ActiveCol>5</ActiveCol>
     <RangeSelection>R3C6:R3C7</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>';
 
 $book.='<Worksheet ss:Name="Enrollments">
  <Table ss:ExpandedColumnCount="26" ss:ExpandedRowCount="1000" x:FullColumns="1"
   x:FullRows="1" ss:StyleID="s62" ss:DefaultColumnWidth="75.75"
   ss:DefaultRowHeight="15">
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="204"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="77.25"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="75"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="61.5"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="48.75"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="51"/>
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="48" ss:Span="19"/>
   <Row ss:AutoFitHeight="0">
    <Cell ss:MergeAcross="4" ss:MergeDown="2" ss:StyleID="s155"><Data
      ss:Type="String">' . $company['company_name'] . ' - Active</Data></Cell>
    <Cell ss:StyleID="s156"/>
   </Row>
   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="6" ss:StyleID="s156"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5">
    <Cell ss:Index="6" ss:StyleID="s156"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="27.75">
    <Cell ss:MergeAcross="4" ss:StyleID="s158"/>
    <Cell ss:StyleID="s156"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="42">
    <Cell ss:StyleID="s159"><Data ss:Type="String">Employee Name</Data></Cell>
    <Cell ss:StyleID="s160"><Data ss:Type="String">Effective Date</Data></Cell>
    <Cell ss:StyleID="s161"><Data ss:Type="String">Medical </Data></Cell>
    <Cell ss:StyleID="s159"><Data ss:Type="String">Plan Election</Data></Cell>
    <Cell ss:StyleID="s159"><Data ss:Type="String">QTY</Data></Cell>
    <Cell ss:StyleID="s67"/>
   </Row>';
   foreach($enrollments as $d) {
     $book.='<Row ss:AutoFitHeight="0" ss:Height="16.5">';
     $book.='<Cell ss:StyleID="s162"><Data ss:Type="String">' . $d['last_name'] . ', ' . $d['first_name'] . '</Data></Cell>';
	$book.='    <Cell ss:StyleID="s163"><Data ss:Type="String">' . $d['eff_dt'] . '</Data></Cell>';
	$book.='    <Cell ss:StyleID="s163"><Data ss:Type="String">' . $d['client_plan'] . '</Data></Cell>';
	$book.='    <Cell ss:StyleID="s163"><Data ss:Type="String">' . $d['coverage_level'] . '</Data></Cell>';
	$book.='    <Cell ss:StyleID="s163"><Data ss:Type="Number">1</Data></Cell>';
	$book.='   </Row>';
   }
$book.='<Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:StyleID="s167"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s74"><Data ss:Type="Number">' . $count . '</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:StyleID="s167"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:MergeAcross="1" ss:StyleID="m1830727606680"><Data ss:Type="String">Employee Only</Data></Cell>
    <Cell ss:StyleID="s163"><Data ss:Type="Number">' . $ee . '</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:MergeAcross="1" ss:StyleID="m1830727606700"><Data ss:Type="String">Employee &amp; Spouse</Data></Cell>
    <Cell ss:StyleID="s163"><Data ss:Type="Number">' . $es . '</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:MergeAcross="1" ss:StyleID="m1830727606720"><Data ss:Type="String">Employee &amp; Child(ren)</Data></Cell>
    <Cell ss:StyleID="s163"><Data ss:Type="Number">' . $ec . '</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:MergeAcross="1" ss:StyleID="m1830727606740"><Data ss:Type="String">Employee &amp; Family </Data></Cell>
    <Cell ss:StyleID="s163"><Data ss:Type="Number">' . $fam .'</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s67"/>
    <Cell ss:StyleID="s163" ss:Formula="=SUM(R[-4]C:R[-1]C)"><Data ss:Type="Number">' . $count . '</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="15.75">
    <Cell ss:Index="2" ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
    <Cell ss:StyleID="s146"/>
   </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0"/>
    <Footer x:Margin="0"/>
    <PageMargins x:Bottom="0.75" x:Left="0.25" x:Right="0.25" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <TopRowVisible>1</TopRowVisible>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>24</ActiveRow>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>';

echo $book;
?>

