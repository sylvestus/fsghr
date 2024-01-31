<?php
include_once 'Sample_Header.php';
$employeename=$_REQUEST['employeename'];
$postaladdress=$_REQUEST['poastal'];
$idno=$_REQUEST['IDNO'];
$dob=$_REQUEST['dob'];
$company=$_REQUEST['company'];
$dateofcommencement=$_REQUEST['joineddate'];
$salary=$_REQUEST['salary'];
$department=$_REQUEST['dept'];
$postalcode=$_REQUEST["poastalcode"];
$pinno=$_REQUEST["pin"];
$nhif=$_REQUEST["nhif"];
$nssf=$_REQUEST["nssf"];

// New Word document
echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->addFontStyle('myOwnStyle', array('color' => 'FF0000'));
$phpWord->setDefaultParagraphStyle(
    array(
        'alignment'  => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
        'spacing'    => 120,
    )
);
$phpWord->addFontStyle('myOwnStyle', array('color' => 'FF0000'));
$phpWord->setDefaultParagraphStyle(
    array(
        'alignment'  => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
        'spacing'    => 120,
    )
);
$phpWord->addNumberingStyle(
    'multilevel',
    array(
        'type'   => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
            array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
        ),
    )
);

$phpWord->addParagraphStyle(
    'centerTab',
    array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('center', 4680)))
);
//$predefinedMultilevel = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED);
// New portrait section
$section = $phpWord->addSection();

// Add first page header
$header = $section->addHeader();
$header->firstPage();
$table = $header->addTable();
$table->addRow();
$cell = $table->addCell(4500);
$textrun = $cell->addTextRun();
$textrun->addText(htmlspecialchars('Staff Entry Form', ENT_COMPAT, 'UTF-8'));
$table->addCell(4500)->addImage('resources/megagroups.png', array('width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));


// Two text break
$section->addTextBreak();
//$section->addText(htmlspecialchars("\tCenter Aligned", ENT_COMPAT, 'UTF-8'), null, 'centerTab');
$section->addText(htmlspecialchars("\t\t\t\t\tSTAFF ENTRY FORM\t\t\t\t", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');
// Write some text
//$section->addTextBreak();
$section->addText(htmlspecialchars('NAME: MR./ MS: '.$employeename."                             ID NO: ".$idno, ENT_COMPAT, 'UTF-8'), array('bold' => true));
//$section->addTextBreak();
$section->addText(htmlspecialchars('DATE OF BIRTH : '.$dob.'                             JOINING DATE: '.$dateofcommencement, ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('DEPARTMENT: '.$department.'                             DESIGNATION: '.$_REQUEST['designation'], ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('PIN NO: '.$pinno.'                             NSSF NO: '.$nssfno, ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('PIN NO: '.$nhifno, ENT_COMPAT, 'UTF-8'), array('bold' => true));

$section->addText(htmlspecialchars("Contact Details", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');
$section->addText(htmlspecialchars('POSTAL ADDRESS: '.$boxno.'			 CODE: '.$postalcode.' 	TOWN: '.$_REQUEST['town'], ENT_COMPAT, 'UTF-8'), array('bold' => true));

$section->addText(htmlspecialchars('TELEPHONE NO: '.$_REQUEST['telephone'], ENT_COMPAT, 'UTF-8'), array('bold' => true));

$section->addText(htmlspecialchars('EMAIL ADDRESS: '.$_REQUEST['email'], ENT_COMPAT, 'UTF-8'), array('bold' => true));

$section->addText(htmlspecialchars("Bank Account Details", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');

$section->addText(htmlspecialchars('BANK ACCOUNT NO: '.$_REQUEST['acno'], ENT_COMPAT, 'UTF-8'), array('bold' => true));

$section->addText(htmlspecialchars('BANK NAME: '.$_REQUEST['bankname'].'		BANK CODE: '.$bankcode, ENT_COMPAT, 'UTF-8'), array('bold' => true));

$section->addText(htmlspecialchars('BRANCH NAME: '.$_REQUEST['branchname'].'		BRANCH CODE '.$branchcode, ENT_COMPAT, 'UTF-8'), array('bold' => true));


$section->addText(htmlspecialchars("\t\t\t\t\tFOR OFFICIAL USE ONLY\t\t\t\t", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');

$section->addText(htmlspecialchars('PAYROLL NO:  '.$payrollno.'			BASIS: CASUAL / PERMANENT '.$basis, ENT_COMPAT, 'UTF-8'), array('bold' => true)); 


$section->addText(htmlspecialchars('SALARY: KSHS.  '.$salary.'				COST CENTRE: '.$costcenter, ENT_COMPAT, 'UTF-8'), array('bold' => true));
 

$section->addText(htmlspecialchars('RECRUITED BY (HOD): 	'.$hod.'			PROCESSED BY (FINANCE CONTROLLER): '.$financecontroller, ENT_COMPAT, 'UTF-8'), array('bold' => true));
			

$section->addText(htmlspecialchars('APPROVED BY (DIRECTOR):  '.$director.'			DATE APPROVED: '.date('d-m-y'), ENT_COMPAT, 'UTF-8'), array('bold' => true));
		
$section->addPageBreak();
$section->addText(htmlspecialchars("\t\t\t\t\tSTAFF CHECKLIST\t\t\t\t", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');
$section->addCheckBox('chkBox1', htmlspecialchars('     Appointment Letter', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox2', htmlspecialchars('     Academic Transcripts (copies)', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox3', htmlspecialchars('     Passport size photos', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox4', htmlspecialchars('     National ID Card (Copy)', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox5', htmlspecialchars('     NSSF Card No (copy)', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox6', htmlspecialchars('     NHIF Card (copy)', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox7', htmlspecialchars('     KRA PIN Card (copy)', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox8', htmlspecialchars('     Certificate of Good Conduct', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addCheckBox('chkBox9', htmlspecialchars('     Bank Account Details', ENT_COMPAT, 'UTF-8'), array('bold' => true));

//add footer
$footer = $section->addFooter();
$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.', ENT_COMPAT, 'UTF-8'), null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}


?>
