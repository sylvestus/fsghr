<?php

/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class NssfRatesDao extends BaseDao {

    public function getNssfRatesById($id) {
        try {
            return Doctrine::getTable('Nssf')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function saveNssfRates(NssfRate $subunit) {
        try {
            if ($subunit->getId() == '') {
                $subunit->setId(0);
            } else {
                $tempObj = Doctrine::getTable('Nssf')->find($subunit->getId());

                $tempObj->setEmployerContribution($subunit->getEmployerContribution() );
                $tempObj->setEmployeeContribution($subunit->getEmployeeContribution());
               
                $subunit = $tempObj;
            }

            $subunit->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }



    public function deleteNssfRates($id) {
        try {
            $q = Doctrine_Query::create()
                            ->delete('Nssf')
                         ->where(" `id`=$id");
            $q->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
//get rate from amount
        public static function getRateFromAmount($amount,$maxamount) {
        try {
            //refine rules here
            //return Doctrine_Query::create()->from('Nssf')->where ('minfigure<= ',$amount)->andWhere('maxfigure >= ',$amount)->execute();
            if($amount<$maxamount){
                return round(($amount*0.06));
            //return round(($amount*0.06)+($amount*0.06));
            }
            else{
                return round(($maxamount*0.06));
                // return round(($maxamount*0.06)+($maxamount*0.06));
                
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
   

    public function getNssfRatesTreeObject() {
        try {
            return Doctrine::getTable('Nssf')->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
