<?php
include_once 'Sample_Header.php';

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
    array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('center', 5680)))
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
$textrun->addText(htmlspecialchars('Leave Application Form', ENT_COMPAT, 'UTF-8'));
$table->addCell(4500)->addImage('resources/megagroups.png', array('width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));


// Two text break
$section->addTextBreak();
//$section->addText(htmlspecialchars("\tCenter Aligned", ENT_COMPAT, 'UTF-8'), null, 'centerTab');
$section->addText(htmlspecialchars("\t\t\t\t\tLEAVE APPLICATION FORM\t\t\t\t", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');
// Write some text
$section->addListItem(htmlspecialchars('Name of Applicant:  '.$employeename.' of ID No. '.$idno.' and Branch / Department '.$department, ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('No. of Days applied for '.$leavedays.' From '.$from.' to '.$to, ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('To report back on: '.$dateofreporting, ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Balance of Leave days brought forward: '.$leavebalance, ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('This Years Entitlement: '.$daysthisyear, ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Total No. of Leave days: '.$leavedaystotal, ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Days remaining after this application: '.$daysremaining, ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Person to relieve the applicant while on Leave:', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Name: '.$nameofreplacingempployee.'  Job Title: '.$jobtitle, ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Applicant’s contact address while on leave:', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Telephone No : '.$telephoneno.'  Alternative Telephone No :'.$othertelephoneno, ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Signature of Applicant: ........................... Date: '.date('d-m-y'), ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Leave Recommended / Rejected by: ', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Name: '.$nameofrecommender.'  Sign: ................................', ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Leave Approved / Rejected by: ', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Name: '.$nameofapprover.'  Sign: ................................', ENT_COMPAT, 'UTF-8'), 1, null, 'multilevel');
$section->addListItem(htmlspecialchars('Employee’s Declaration: ', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');

$section->addText( htmlspecialchars(
        'I hereby confirm that I have taken my Annual Leave and further agree that I have no claim against the Company for any outstanding dues or days in lieu of my Annual Leave to (Month) '.$month.' (Year) '.  date('y').' Signature _______________________________ Date: '.date('d-m-y'),
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false,'italic' => true,'space' => array('before' => 360, 'after' => 480))
);
$section->addText( htmlspecialchars(
        '(Note: - Incase your services are required, you will be called back prior to completion of your Leave)',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => true,'italic' => true,'space' => array('before' => 300, 'after' => 480))
);
// Add footer
$footer = $section->addFooter();
$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.', ENT_COMPAT, 'UTF-8'), null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}


?>
