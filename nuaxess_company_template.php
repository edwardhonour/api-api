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
$output=array();
//$company_id=$data['id'];
$company_id = "5556";

$sql="select * from nua_company where id = " . $company_id;
$co=$X->sql($sql);
$company=$co[0];
$company_name=$company['company_name'];
$file_name=str_replace(" ","_",$company_name) . "_Template.xml";

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
  <Author>Edward Honour</Author>
  <LastAuthor>Edward Honour</LastAuthor>
  <Created>2022-03-11T15:24:39Z</Created>
  <LastSaved>2022-03-14T14:40:39Z</LastSaved>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>15840</WindowHeight>
  <WindowWidth>29040</WindowWidth>
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
  <Style ss:ID="s16" ss:Name="Hyperlink">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#0563C1"
    ss:Underline="Single"/>
  </Style>
  <Style ss:ID="s17">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#E7E6E6" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s18">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s19">
   <Alignment ss:Vertical="Top"/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s22">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Interior ss:Color="#F2F2F2" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s23">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="24" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s26" ss:Parent="s16">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#E7E6E6" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s27">
   <NumberFormat ss:Format="Short Date"/>
  </Style>
  <Style ss:ID="s28">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s30">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
  </Style>
  <Style ss:ID="s78">
   <Interior ss:Color="#F2F2F2" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s79">
   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#E7E6E6" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s80">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#E7E6E6" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s81">
   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#E7E6E6" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s85">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"/>
    <Border ss:Position="Left" ss:LineStyle="Double" ss:Weight="3"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s86">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s87">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="3"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Top" ss:LineStyle="Double" ss:Weight="3"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
 </Styles>';
 
 $book.='<Worksheet ss:Name="Prospect">
  <Table ss:ExpandedColumnCount="4" ss:ExpandedRowCount="24" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:AutoFitWidth="0" ss:Width="183.75"/>
   <Column ss:AutoFitWidth="0" ss:Width="252.75"/>
   <Column ss:AutoFitWidth="0" ss:Width="125.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="246.75"/>';
   
  $book.='   <Row ss:AutoFitHeight="0" ss:Height="33.75" ss:StyleID="s18">
    <Cell ss:StyleID="s23"><Data ss:Type="String">Prospect / Company Data Form</Data></Cell>
    <Cell ss:Index="3"><Data ss:Type="String">Company Address</Data></Cell>
   </Row>';

  $book.='   <Row ss:Height="15.75">
    <Cell ss:StyleID="s18"><Data ss:Type="String">New Company:</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">No</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">If No, Company Id:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[ID]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Company Staus:</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Enrolled</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Address</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[ADDRESS]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Company Name:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[COMPANY_NAME] **</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Line 2:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[SUITE]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Broker Name:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[BROKER_NAME]</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">City</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[CITY]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Broker Email:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:ehonour@nuaxess.com"><Data
      ss:Type="String">[BROKER_EMAIL]</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">State:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[STATE]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Company Type:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">C Corp</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Zip:</Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String">[ZIP]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Tax ID:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[TAX_ID]</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Website:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="https://gexlabs.com/"><Data ss:Type="String">[WEBSITE]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Contact Name</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[CONTACT_NAME]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Contact Phone</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[CONTACT_PHONE]</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Billing Address</Data></Cell>
    <Cell ss:StyleID="s18"/>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Contact Email:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:jeff@tritaniumlabs.com"><Data
      ss:Type="String"> [CONTACT_EMAIL]</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Company Name:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_COMPANY_NAME]</Data></Cell>
   </Row>';

  $book.='   <Row>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Number of Employees:</Data></Cell>
    <Cell ss:StyleID="s80"><Data ss:Type="String">1-10</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Address</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_COMPANY_ADDRESS]</Data></Cell>
   </Row>';
   
  $book.='   <Row ss:AutoFitHeight="0" ss:Height="134.25">
    <Cell ss:StyleID="s18"><Data ss:Type="String">Current Insurance Provider:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String"> [CURRENT_INVOICE_PROVIDER] </Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Line 2:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_COMPANY_SUITE]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s19"><Data ss:Type="String">Industry:</Data></Cell>
    <Cell ss:StyleID="s81"><Data ss:Type="String">[DSC]</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">City</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_COMPANY_CITY]</Data></Cell>
   </Row>';
   
  $book.='   <Row ss:Height="15.75">
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">State:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_COMPANY_STATE]</Data></Cell>
   </Row>';
   
  $book.='   <Row ss:Height="15.75">
    <Cell ss:StyleID="s18"><Data ss:Type="String">Quote Medical?</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">No</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Zip:</Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String">[INVOICE_COMPANY_CITY]</Data></Cell>
   </Row>';
   
  $book.='   <Row ss:Height="15.75">
    <Cell ss:StyleID="s18"><Data ss:Type="String">Quote Dental?</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">No</Data></Cell>
   </Row>';
   
  $book.='   <Row ss:Height="15.75">
    <Cell ss:StyleID="s18"><Data ss:Type="String">Quote Vision?</Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String">No</Data></Cell>
    <Cell ss:StyleID="s18"><Data ss:Type="String">Billing Contact Name:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_CONTACT_NAME]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:StyleID="s18"/>
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">Billing Contact Email:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:jlozinski@artfin.com"><Data
      ss:Type="String">[INVOICE_CONTACT_EMAIL]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">Billing Contact Phone:</Data></Cell>
    <Cell ss:StyleID="s17"><Data ss:Type="String">[INVOICE_CONTACT_PHONE]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">Billing Contact Email #2:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:ehonour@nuaxess.com"><Data
      ss:Type="String">[INVOICE_CONTACT_EMAIL2]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">Billing Contact Email #3:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:ed@edhonour.com"><Data ss:Type="String">[INVOICE_CONTACT_EMAIL3]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">Billing Contact Email #4:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:ehonour@anl.gov"><Data ss:Type="String">[INVOICE_CONTACT_EMAIL4]</Data></Cell>
   </Row>';
   
  $book.='   <Row>
    <Cell ss:Index="3" ss:StyleID="s18"><Data ss:Type="String">Billing Contact Email #5:</Data></Cell>
    <Cell ss:StyleID="s26" ss:HRef="mailto:edwardhonour@gmail.com"><Data
      ss:Type="String">[INVOICE_CONTACT_EMAIL5]</Data></Cell>
   </Row>';
   
  $book.='</Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>12</ActiveRow>
     <ActiveCol>3</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R2C2,R16C2:R19C2</Range>
   <Type>List</Type>
   <CellRangeList/>
   <Value>&quot;Yes,No&quot;</Value>
  </DataValidation>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R12C2</Range>
   <Type>List</Type>
   <CellRangeList/>
   <Value>&quot;1-10, 11 or more&quot;</Value>
  </DataValidation>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R7C2</Range>
   <Type>List</Type>
   <CellRangeList/>
   <Value>&quot;C Corp, S Corp, LLC&quot;</Value>
  </DataValidation>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R3C2</Range>
   <Type>List</Type>
   <CellRangeList/>
   <Value>&quot;Prospect,Enrolling,Enrolled&quot;</Value>
  </DataValidation>
 </Worksheet>
 <Worksheet ss:Name="Preenrollment-Census">
  <Table ss:ExpandedColumnCount="9" ss:ExpandedRowCount="4" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:AutoFitWidth="0" ss:Width="129"/>
   <Column ss:AutoFitWidth="0" ss:Width="151.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="202.5"/>
   <Column ss:StyleID="s30" ss:AutoFitWidth="0" ss:Width="140.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="128.25"/>
   <Column ss:StyleID="s30" ss:AutoFitWidth="0" ss:Width="148.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="95.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="90"/>
   <Column ss:AutoFitWidth="0" ss:Width="96"/>
   <Row ss:AutoFitHeight="0" ss:Height="33.75" ss:StyleID="s18">
    <Cell ss:StyleID="s23"><Data ss:Type="String">Preenrollment Census</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s28"/>
    <Cell ss:Index="6" ss:StyleID="s28"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="117">
    <Cell ss:StyleID="s85"><Data ss:Type="String">Member ID Number            (Social Security Number)                        </Data></Cell>
    <Cell ss:StyleID="s86"><Data ss:Type="String">Dependent ID Number                      (Social Security Number)                        </Data></Cell>
    <Cell ss:StyleID="s87"><Data ss:Type="String">Last Name</Data></Cell>
    <Cell ss:StyleID="s87"><Data ss:Type="String">First Name</Data></Cell>
    <Cell ss:StyleID="s86"><Data ss:Type="String">Middle Initial</Data></Cell>
    <Cell ss:StyleID="s86"><Data ss:Type="String">Relationship (Employee, Husband, Wife Son, Daughter)</Data></Cell>
    <Cell ss:StyleID="s86"><Data ss:Type="String">Date of Birth</Data></Cell>
    <Cell ss:StyleID="s86"><Data ss:Type="String">Gender - F/M</Data></Cell>
    <Cell ss:StyleID="s86"><Data ss:Type="String">Marital Status - S/M</Data><Comment
      ss:Author="Natette"><ss:Data xmlns="http://www.w3.org/TR/REC-html40"><Font
        html:Face="Tahoma" x:Family="Swiss" html:Size="9" html:Color="#000000">Married, Single, Separated, Widowed&#10;</Font></ss:Data></Comment></Cell>
   </Row>
   <Row ss:Height="15.75">
    <Cell><Data ss:Type="String">[SOCIAL_SECURITY_NUMBER]</Data></Cell>
    <Cell><Data ss:Type="String">[DEPENDENT_SOCIAL_SECURITY_NUMBER]</Data></Cell>
    <Cell><Data ss:Type="String">[LAST_NAME]</Data></Cell>
    <Cell ss:StyleID="Default"><Data ss:Type="String">[FIRST_NAME]</Data></Cell>
    <Cell ss:StyleID="s27"><Data ss:Type="String">[MIDDLE_NAME]</Data></Cell>
    <Cell><Data ss:Type="String">[RELATIONSHIP]</Data></Cell>
    <Cell ss:StyleID="s27"><Data ss:Type="DateTime">2021-01-14T00:00:00.000</Data></Cell>
    <Cell><Data ss:Type="String">M</Data></Cell>
    <Cell><Data ss:Type="String">S</Data></Cell>
   </Row>
   <Row>
    <Cell ss:Index="5" ss:StyleID="s27"/>
   </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>1</ActiveRow>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R3C7:R935C7</Range>
   <Type>Date</Type>
   <Min>1</Min>
   <Max>47483</Max>
  </DataValidation>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R3C8:R1272C8</Range>
   <Type>List</Type>
   <CellRangeList/>
   <Value>&quot;F,M&quot;</Value>
  </DataValidation>
  <DataValidation xmlns="urn:schemas-microsoft-com:office:excel">
   <Range>R3C9:R253C9</Range>
   <Type>List</Type>
   <CellRangeList/>
   <Value>&quot;M,S&quot;</Value>
  </DataValidation>
 </Worksheet>
</Workbook>';


echo $book;
?>
