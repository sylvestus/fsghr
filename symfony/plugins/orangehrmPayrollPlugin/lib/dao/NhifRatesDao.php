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
class NhifRatesDao extends BaseDao {

    public function getNhifRatesById($id) {
        try {
            return Doctrine::getTable('NhifRates')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function NhifRates(NhifRates $subunit) {
        try {
            if ($subunit->getId() == '') {
                $subunit->setId(0);
            } else {
                $tempObj = Doctrine::getTable('NhifRates')->find($subunit->getId());

                $tempObj->setMinfigure($subunit->getMinfigure());
                $tempObj->setMaxfigure($subunit->getMaxfigure());
                $tempObj->setAmount($subunit->getAmount());
                $subunit = $tempObj;
            }

            $subunit->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function addNhifRates($data) {
        $nhif=new NhifRates();
        try {
            $nhif->setMinfigure($data['minfigure']);
             $nhif->setMaxfigure($data['maxfigure']);
             $nhif->setAmount($data['amount']);
$nhif->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function deleteNhifRates($id) {
        try {
            $q = Doctrine_Query::create()
                            ->delete('NhifRates')
                         ->where(" `id`=$id");
            $q->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

   //get rate from amount
    public static function getRateFromAmount($amount) {
        $em= Doctrine_Manager::getInstance()->getCurrentConnection();
        
        $sql="SELECT amount from nhif_rates where minfigure <=$amount AND maxfigure >=$amount ";
        $stmnt=$em->execute($sql);
        $result=$stmnt->fetch();
        //echo $amount." nhif=>".$result["amount"].'<br>';
        return $result["amount"];
    }

    public function getNhifRatesTreeObject() {
        try {
            return Doctrine::getTable('NhifRates')->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
