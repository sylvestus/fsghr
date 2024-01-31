<?php

class DeductionsDao extends BaseDao {

     public static function getDeductions() {
        try {
 
            return OhrmSalaryDeductionsTable::getInstance()->findAll();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
      public static function hydrateDeductions() {
        try {
$deductions=OhrmSalaryDeductionsTable::getInstance()->findAll();
foreach ($deductions as $deduction) {
    $choices[$deduction->getId()]=$deduction->getName();
}
return $choices;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    //for choice list
    
    
    public static function getDeductionById($id) {
    $deduction=OhrmSalaryDeductionsTable::getInstance()
  ->createQuery()
   ->where(" `id`='$id'")
  ->execute();
    return $deduction[0];
        //added for terminated employees not to show
                              
      
         //return Doctrine:: getTable('OhrmSalaryDeductionsTable')->findBy("id",$id);
//        try {
//          
//            return OhrmSalaryDeductionsTable::getInstance()->find($id);
//        } catch (Exception $e) {
//            throw new DaoException($e->getMessage());
//        }
    }
    

    
    
    //delete
    public function deleteDeduction($id) {
        try {
             $deletequery= OhrmSalaryDeductionsTable::getInstance()
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
            return  OhrmSalaryDeductionsTable::getInstance()->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
