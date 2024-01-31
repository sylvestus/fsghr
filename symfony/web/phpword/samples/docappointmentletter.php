<?php
include_once 'Sample_Header.php';

$employeename=  htmlspecialchars($_REQUEST['employeename']);
$postaladdress=htmlspecialchars($_REQUEST['poastal']);
$idno=htmlspecialchars($_REQUEST['IDNO']);
$dob=htmlspecialchars($_REQUEST['dob']);
$company=htmlspecialchars($_REQUEST['company']);
$dateofcommencement=htmlspecialchars($_REQUEST['joineddate']);
$salary=htmlspecialchars($_REQUEST['salary']);
$postaladdress=htmlspecialchars($_REQUEST['poastal']);
$jobtitle=htmlspecialchars($_REQUEST['jobtitle']);

$probationperiod="6";
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
$textrun->addText(htmlspecialchars('JOB OFFER LETTER FOR SHILOAH INVESTMENTS GROUP', ENT_COMPAT, 'UTF-8'));
$table->addCell(4500)->addImage('resources/megagroups.png', array('width' => 80, 'height' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));

// Add header for all other pages
//$subsequent = $section->addHeader();
//$subsequent->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'));
//$subsequent->addImage('resources/_mars.jpg', array('width' => 80, 'height' => 80));

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// New portrait section


// Two text break
$section->addTextBreak(2);
// Write some text
//$section->addTextBreak();
$section->addText(htmlspecialchars('NAME OF EMPLOYEE: '.$employeename, ENT_COMPAT, 'UTF-8'), array('bold' => true));
//$section->addTextBreak();
$section->addText(htmlspecialchars('POSTAL ADDRESS: '.@$postaladdress.'               P.O. BOX :  '.@$box.'             CODE:   '.@$code.' ', ENT_COMPAT, 'UTF-8'), array('bold' => true));
//$section->addTextBreak();
$section->addText(htmlspecialchars('ID CARD NO: ----------------'.$idno.'--------------------------- SERIAL NO: ----------------------------'.@$serialno.'--------------------------------------------------                                                  ', ENT_COMPAT, 'UTF-8'), array('bold' => true));
//$section->addTextBreak();
$section->addText(htmlspecialchars('PLACE OF ISSUE: -----------------'.@$placeofissue.'---------------------- DATE OF ISSUE: ---------------------------'.@$dateofissue.'---------------------------------------------------                                               ', ENT_COMPAT, 'UTF-8'), array('bold' => true));
//$section->addTextBreak();
$section->addText(htmlspecialchars('DISTRICT OF BIRTH: -------------------------'.@$districtob.'-----------------------------------------------------                               DATE OF BIRTH: ----------------------------------'.$dob.'--------------------------------------------                                              ', ENT_COMPAT, 'UTF-8'), array('bold' => true));
$section->addTextBreak();
$section->addText(htmlspecialchars('LETTER OF APPOINTMENT FOR NON-UNIONISABLE EMPLOYEES', ENT_COMPAT, 'UTF-8'), array('bold' => true),  null, 3);

// New portrait section

//$section->addText(htmlspecialchars('TITLE', ENT_COMPAT, 'UTF-8'), array('bold' => true),  null, 3);
$section->addText( htmlspecialchars(
        'This letter confirms your appointment as an employee of '.$company.
        ' on the following terms and condition of service.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText(htmlspecialchars('DUTIES: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars(
        'You will be employed initially as a '.$jobtitle.' but your function and duties may be altered at the discretion of the Management.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);

$section->addText(htmlspecialchars('DATE OF COMMENCEMENT: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars(
        'You will be required to commence employment with effect from '.$dateofcommencement,
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText(htmlspecialchars('SALARY: ', ENT_COMPAT, 'UTF-8'), array('bold' => true,  'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars(
        'You will be paid in arrears at the end of each month as a consolidated salary of Kshs. '.$salary.' including House Allowance',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);

$section->addText(htmlspecialchars('PROBATION: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars(
        'You will be on Probation in the first instance for a period of '.$probationperiod.' months which may be extended for further period according to the discretion of the management during which time 15 days notice or pay in lieu of either side will be required',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addText(htmlspecialchars('LEAVE: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars(
        'On completion of twelve months’ Service, you will be eligible for 24 days paid leave. All leave to be taken at the discretion of the Management.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);

$section->addText(htmlspecialchars('WORKING HOURS: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars('Your working hours will be 48 hours per week. The Management from time to time depending on the organization’s operational needs will determine the time of reporting and departure from work.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);

 
$section->addText(htmlspecialchars('CONFIDENTIAL MATTERS: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars('You will not, without the written consent of the Company, disclose any of its secrets or other confidential matters to anyone.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);

$section->addText(htmlspecialchars('TERMINATION OF EMPLOYMENT: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars('At any time after satisfactory completion of your probationary service, the Company shall be entitled to terminate this agreement by giving you one Month notice in writing or to pay one month salary in lieu of such notice. This is without prejudice of the Company’s right to terminate the employment summarily for a lawful cause. If during your period of service, you would wish to leave the service of Company, you must give the Company one-month notice of your intention or forfeit your salary for the period by which your notice falls short of.',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);   

$section->addText(htmlspecialchars('STANDING ORDERS: ', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addText( htmlspecialchars('You are required to make yourself familiar with, and abide by such standing orders as shall from time to time be issued by the Company.

You will not, without the consent of the Management of the company engage in any other business or occupation, which would be in conflict with your duties as a full time employee of the Company.

This letter is sent to you in duplicate and we shall be grateful if you sign one copy and return it to us signifying that you have accepted the above terms and conditions.

When reporting on duty, please produce the following:',
        ENT_COMPAT,
        'UTF-8' ),
    array('bold' => false),  array('space' => array('before' => 360, 'after' => 480))
);
$section->addTextBreak(2);
$section->addListItem(htmlspecialchars('Copies of Academic & Professional certificates', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Copy of Identity Card', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('2 Colored Passport size photos', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Copy of National Social Security Fund Card', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Copy of National Hospital Insurance Fund Card', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Copy KRA PIN', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Certificate of Good Conduct', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');
$section->addListItem(htmlspecialchars('Salary remittance bank account details', ENT_COMPAT, 'UTF-8'), 0, null, 'multilevel');

$section->addTextBreak();
$section->addText(htmlspecialchars('Yours faithfully,', ENT_COMPAT, 'UTF-8'));
$section->addText(htmlspecialchars('FOR: '.$company, ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);
$section->addTextBreak(2);

$section->addText(htmlspecialchars('HUMAN RESOURCES MANAGER', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);

$section->addText(htmlspecialchars('DECLARATION:', ENT_COMPAT, 'UTF-8'), array('bold' => true, 'underline' => 'single'),  null, 3);

$section->addText(htmlspecialchars('I hereby accept the above-mentioned Terms and Conditions of employment, which have been read and understood by me.', ENT_COMPAT, 'UTF-8'));

$section->addText(htmlspecialchars('EMPLOYEE’S NAME: _____________________'.$employeename.'_______________________________', ENT_COMPAT, 'UTF-8'), array('bold' => true),  null, 3);

$section->addTextBreak(2);
$section->addText(htmlspecialchars('SIGNATURE: _____________________________	DATE: ______'.date("y-m-d").'_____________', ENT_COMPAT, 'UTF-8'), array('bold' => true),  null, 3);



// Add footer
$footer = $section->addFooter();
$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.', ENT_COMPAT, 'UTF-8'), null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
// Save file
ob_clean();
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}


?>
