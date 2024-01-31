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

// New portrait section
$section = $phpWord->addSection();

// Add first page header
$header = $section->addHeader();
$header->firstPage();
$table = $header->addTable();
$table->addRow();
$cell = $table->addCell(4500);
$textrun = $cell->addTextRun();
$textrun->addText(htmlspecialchars('Employee Dismissal Letter', ENT_COMPAT, 'UTF-8'));
$table->addCell(4500)->addImage('resources/megagroups.png', array('width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));


// Two text break
//$section->addTextBreak();
//$section->addText(htmlspecialchars("\tCenter Aligned", ENT_COMPAT, 'UTF-8'), null, 'centerTab');
//$section->addText(htmlspecialchars("\t\t\t\t\tDISMISSAL LETTER\t\t\t\t", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 'centerTab');
// Write some text
//$section->addTextBreak();
$section->addText(htmlspecialchars('Date  '.date('d-m-y'), ENT_COMPAT, 'UTF-8'), array('bold' => false));
$section->addText(htmlspecialchars('Employee Name  '.$employeename, ENT_COMPAT, 'UTF-8'), array('bold' => false));
$section->addText(htmlspecialchars('Address '.$address, ENT_COMPAT, 'UTF-8'), array('bold' => false));
$section->addText(htmlspecialchars('Dear '.$designation, ENT_COMPAT, 'UTF-8'), array('bold' => false));
$section->addText(htmlspecialchars("SUB: SUMMARY DISMISSAL", ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 3);

$section->addText( htmlspecialchars(
        'This is to inform you that your employment with '.$company. '(company name) has been stopped with effect from '.$dateofexit.' due to the following reasons',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
//$section->addTextBreak();
$section->addListItem(htmlspecialchars('------------------------------------------------------------', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('------------------------------------------------------------', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('------------------------------------------------------------', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');

$section->addText( htmlspecialchars(
        'A pre-disciplinary meeting was conducted on      '.$dateofdisplinarymeeting.'      (date), and the above mentioned gross misconducts were discussed and how they impact company operations.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);

$section->addText( htmlspecialchars(
        'In lieu of the above and all information available, including prior disciplinary actions and your comments (or lack of comments) during the pre-disciplinary meeting, you are being dismissed from your position effective      '.$dateofexit.' (date).',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText( htmlspecialchars(
        'Please return all company property in your possession to your immediate supervisor/ HOD to facilitate processing of your final salary and any other dues if any.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText( htmlspecialchars(
        'You have the right to appeal within three months from the date of this letter to the Labor Office your dismissal; however, the appeal will not halt your dismissal',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText(htmlspecialchars('Yours trully,', ENT_COMPAT, 'UTF-8'), array('bold' => false));
$section->addText(htmlspecialchars('For Shiloah Investments Limited', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addBreak();
$section->addText(htmlspecialchars('Human Resources Manager', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addText(htmlspecialchars('Cc: The Labor officer', ENT_COMPAT, 'UTF-8'), array('bold' => false));

// Add footer
$footer = $section->addFooter();
$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.', ENT_COMPAT, 'UTF-8'), null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}


?>
