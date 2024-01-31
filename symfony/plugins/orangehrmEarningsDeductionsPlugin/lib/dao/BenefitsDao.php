<?php

class BenefitsDao extends BaseDao {
     public static function getBenefits() {
        try {
         
            return OhrmBenefitsTable::getInstance()->findAll();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
      public static function hydrateBenefits() {
        try {
$earnings= OhrmBenefitsTable::getInstance()->findAll();
foreach ($earnings as $earning) {
    $choices[$earning->getId()]=$earning->getName();
}
return $choices;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    //for choice list
    
    
    public static function getBenefitById($id) {
        try {
            return OhrmBenefitsTable::getInstance()->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    //delete
    public function deleteBenefit($id) {
        try {
             $deletequery= OhrmBenefitsTable::getInstance()
  ->createQuery()
  ->delete()
  ->where(" `id`=$id")
  ->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }


  
    public function getChargeTreeObject() {
        try {
            return  OhrmBenefitsTable::getInstance()->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
