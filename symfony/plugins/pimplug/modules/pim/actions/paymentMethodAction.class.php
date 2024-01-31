<?php

/**
 * SavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 SavannaHRM Inc., http://www.orangehrm.com
 *
 * SavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * SavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class paymentMethodAction extends basePimAction {

    public function execute($request) {
        $empNumber = $request->getParameter('empNumber');
         $paymethod = $request->getParameter('paymentmode');
        $employee = $this->getEmployeeService()->getEmployee($empNumber);
        $paymeth=HsHrEmpdefaultpaymodeTable::checkIfPaymentMethodExists($empNumber,$paymethod);
       if(!is_array($paymeth)){
           $emppaymethod=new HsHrEmpdefaultpaymode();
           $emppaymethod->setEmpnumber($empNumber);
           $emppaymethod->setPaymentmethod($paymethod);
           $emppaymethod->save();
       }
       else{
           HsHrEmpdefaultpaymodeTable::updateActivePayMethod($empNumber, $paymethod);
       }
      $this->getUser()->setFlash('success', __('Salary Payment method set as '.$paymethod));
    
     $this->redirect('pim/viewSalaryList?empNumber='.$empNumber); 
        
    }

}

