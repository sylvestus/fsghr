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
$textrun->addText(htmlspecialchars('Employee Exit Form', ENT_COMPAT, 'UTF-8'));
$table->addCell(4500)->addImage('resources/megagroups.png', array('width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));


// Two text break
$section->addTextBreak();
//$section->addText(htmlspecialchars("\tCenter Aligned", ENT_COMPAT, 'UTF-8'), null, 'centerTab');
$section->addText(htmlspecialchars("\t\t\t\t\tEMPLOYEE EXIT FORM\t\t\t\t", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');
// Write some text
//$section->addTextBreak();
$section->addText(htmlspecialchars('NAME OF EMPLOYEE: '.$employeename."                             ID NO: ".$idno, ENT_COMPAT, 'UTF-8'), array('bold' => true));
//$section->addTextBreak();
$section->addText(htmlspecialchars('PAYROLL NO: '.$payrollno.'                             JOINING DATE: '.$dateofadmission, ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('DEPARTMENT: '.$department.'                             DESIGNATION: '.$designation, ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('DATE OF EXIT/ TERMINATION / DISMISSAL: '.$dateofexit.'                             DESIGNATION: '.$designation, ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText( htmlspecialchars(
        'Please be advised that the above employee has ceased being an employee of '.$company.' with effect from the above date.',
        ENT_COMPAT,
        'UTF-8' ),
    array('italic' => true),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText(htmlspecialchars('NATURE OF EXIT/TERMINATION:', ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 3);
// New portrait section
//$section->addTextBreak();
$section->addCheckBox('chkBox1', htmlspecialchars('...............Absconded Duty', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addCheckBox('chkBox2', htmlspecialchars('...............End of Contract', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addCheckBox('chkBox3', htmlspecialchars('...............Natural Death', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addCheckBox('chkBox4', htmlspecialchars('...............Resignation', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addCheckBox('chkBox5', htmlspecialchars('...............Summary Dismissal', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addCheckBox('chkBox6', htmlspecialchars('...............Termination of Service', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addCheckBox('chkBox7', htmlspecialchars('...............Others (Specify):', ENT_COMPAT, 'UTF-8'), array('italic' => true));
$section->addText(htmlspecialchars('Non-performance / Medical Ground', ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 3);
//$section->addTextBreak();
$section->addText( htmlspecialchars(
        $specification,
        ENT_COMPAT,
        'UTF-8' ),
    array('italic' => true),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText(htmlspecialchars('Initiated by (HOD):'.$hod.'                             DATE: '.date('d-m-y'), ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('Approved by:'.$approver.'                             DATE: '.date('d-m-y'), ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('Processed by:'.$processor.'                             DATE: '.date('d-m-y'), ENT_COMPAT, 'UTF-8'), array('bold' => true));

// Add footer
$footer = $section->addFooter();
$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.', ENT_COMPAT, 'UTF-8'), null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}


?>
