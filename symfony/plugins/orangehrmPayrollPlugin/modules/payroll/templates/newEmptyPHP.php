'<table><tr><td colspan="2" style="text-align:center"><h3  style="text-align:center"> <?= strtoupper($organisationinfo->getName()) ?></h3><h3 style="text-align:center"><?php echo __("PAYSLIP") ?></h3><?php echo __("MONTH: 01/2018") ?>&nbsp;&nbsp;'
'\n'+'<br>'
           '\n'+' <?php echo __("PAYROLL#SMP001") ?><br>'
    '\n'+'<center style="border-bottom:1px dotted black"><?php echo __("NAME:SAMPLE EMPLOYEE") ?></center>'
    '\n'+'<br>'


    '\n'+'</td>'

    '\n'+'</tr>'

    '\n'+'<tr><td style="text-align:left;font-weight:bold" colspan="2"><?php echo __("EARNINGS") ?>'
        '\n'+'</td></tr>'
   '\n'+' <tr><td style="text-align:left;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?php echo __("GROSS PAY") ?>'
        </td><td style="text-align:right;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?= number_format(data.grosspay, 0) ?></td></tr>'
   '\n'+' <tr><td style="text-align:left;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?php echo __("BENEFITS") ?>'
        </td><td style="text-align:right;font-weight:bold;border-bottom:1px dotted #000;border-top:1px dotted #000"><?= number_format(data.earnings_benefits, 0) ?></td></tr>'
    '\n'+'<tr><td style="text-align:left;" colspan="2"><br></td></tr>'
   '\n'+' <tr><td style="text-align:left;font-weight:bold" colspan="2"> <?php echo __("DEDUCTIONS") ?>'
      '\n'+'  </td></tr>'
    '\n'+' <tr><td style="text-align:left;font-weight:bold"> <?php echo __("PAYE") ?>'
     '\n'+'   </td><td style="text-align:right;font-weight:bold"><?= number_format(data.paye, 0) ?></td></tr>'
       '\n'+' <tr><td style="text-align:left;font-weight:bold"> <?php echo __("NSSF") ?>'
       '\n'+' </td><td style="text-align:right;font-weight:bold"><?= number_format(data.nssf, 0) ?></td></tr>'
       '\n'+'    <tr><td style="text-align:left;font-weight:bold"> <?php echo __("NHIF") ?>'
       '\n'+' </td><td style="text-align:right;font-weight:bold"><?= number_format(data.nhif, 0) ?></td></tr>'
    '\n'+' <tr><td style="text-align:left;font-weight:bold"> <?php echo __("T.DEDUCTIONS") ?>'
       '\n'+' </td><td style="text-align:right;font-weight:bold"><?= number_format(data.deductions, 0) ?></td></tr>'

    '\n'+'<tr><td style="text-align:left;font-weight:bold" colspan="2"> <br> <?php echo __("RELIEFS") ?></td></tr>'
           '\n'+' <tr><td style="text-align:left">PERSONAL RELIEF</td><td style="text-align:right"><?= number_format(data.personal_relief, 0) ?></td></tr>'
          '\n'+'  <tr><td style="text-align:left">INSURANCE RELIEF</td><td style="text-align:right"><?= number_format(data.insurance_relief, 0) ?></td></tr>'
    '\n'+'<tr><td style="text-align:left;font-weight:bold;border-bottom:1px solid #000"><?php echo __("NET PAY:") ?></td>  <td style="text-align:right;font-weight:bold;border-bottom:1px solid #000"><?= number_format(data.netpay, 0) ?></td></tr>'
    '\n'+'<tr><td style="text-align:left;" colspan="2"><br></td></tr>'
'\n'+'<tr><td style="text-align:left;font-weight:bold" colspan="2">SIGNATURE.............. <br>  <br>  <br>  <br>  <br><br>  <br>    </td> </tr>'

'\n'+'</table>';