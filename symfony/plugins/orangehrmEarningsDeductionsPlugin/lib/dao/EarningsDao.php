<?php

class EarningsDao extends BaseDao {

     public static function getEarnings() {
        try {
 
            return OhrmEarningsTable::getInstance()->findAll();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
      public static function hydrateEarnings() {
        try {
$earnings= OhrmEarningsTable::getInstance()->findAll();
foreach ($earnings as $earning) {
    $choices[$earning->getId()]=$earning->getName();
}
return $choices;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    //for choice list
    
    
    public static function getEarningById($id) {
        try {
            return OhrmEarningsTable::getInstance()->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
  
    //delete
    public function deleteEarning($id) {
        try {
             $deletequery= OhrmEarningsTable::getInstance()
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
            return  OhrmEarningsTable::getInstance()->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
