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
class IncomeTaxSlabDao extends BaseDao {

    public function getIncomeTaxSlabById($id) {
        try {
            return Doctrine::getTable('IncomeTaxSlab')->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    public static function getAllIncomeTaxSlabs() {
        try {
            return Doctrine_Query::create()->from('IncomeTaxSlab')->orderBy("minfigure ASC")->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
     public static function getRangeOfAmount($amount) {
        try {
            return Doctrine_Query::create()->from('IncomeTaxSlab')
                    ->where("`minfigure`<=$amount")
                    ->andWhere("`maxfigure`>=$amount")
                    ->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    public static function getSlabsBelowAmount($amount) {
        try {
            return Doctrine_Query::create()->from('IncomeTaxSlab')
                    ->where("`minfigure`< $amount ")
                    ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    

    public function saveIncomeTaxSlab(IncomeTaxSlab $subunit) {
        try {
            if ($subunit->getId() == '') {
                $subunit->setId(0);
            } else {
                $tempObj = Doctrine::getTable('IncomeTaxSlab')->find($subunit->getId());

                $tempObj->setMinfigure($subunit->getMinfigure());
                $tempObj->setMaxfigure($subunit->getMaxfigure());
                $tempObj->setPercentage($subunit->getPercentage());
                $subunit = $tempObj;
            }

            $subunit->save();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function addIncomeTaxSlab(IncomeTaxSlab $parentSubunit, IncomeTaxSlab $subunit) {
        try {
            $subunit->setId(0);
            $subunit->getNode()->insertAsLastChildOf($parentSubunit);

            $parentSubunit->setRgt($parentSubunit->getRgt() + 2);
            $parentSubunit->save();

            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function deleteIncomeTaxSlab($id) {
        try {
             $deletequery=Doctrine::getTable('IncomeTaxSlab')
  ->createQuery()
  ->delete()
  ->where(" `tb_id`=$id")
  ->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    //get payee rate
        public static function getRatesFromAmount($amount) {
           
        //GET THE RANGE WHICH THE AMOUNT LIES
        
        $range=self::getRangeOfAmount($amount);
               $minvalueofrange=$range->minfigure;
               
        $nextlowerrange=$minvalueofrange-1;
        $overflowtax=($amount-$nextlowerrange)*($range->percentage/100);
     
$slabsbelowamount=self::getSlabsBelowAmount($range->minfigure);
$tax=0;
foreach ($slabsbelowamount as $slab) {
    
    $tax+=($slab->maxfigure-$slab->minfigure)*($slab->percentage/100);
}


    $totaltax=$overflowtax+$tax;   

 
         return $totaltax;
        
    
}
    
    
    

 
    public function getIncomeTaxSlabTreeObject() {
        try {
            return Doctrine::getTable('IncomeTaxSlab')->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}