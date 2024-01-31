<?php

class EmployeeBenefitsDao extends BaseDao {

     public static function getBenefitByEmpNumber($empno) {
        try {
            OhrmEmployeeBenefits::STATE_CLEAN;
            return OhrmEmployeeBenefitsTable::getInstance()
                    ->createQuery()
  ->select()
  ->where(" `emp_number`=$empno")
  ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    public static function getEmployeeBenefit($empno,$id) {
        try {
        return Doctrine_Query::create()->from ('OhrmEmployeeBenefits')
       ->select("id")
      ->where(" `benefit_id`=$id")
      ->andWhere(" `emp_number`=$empno")
          ->fetchOne(array(),  Doctrine::HYDRATE_SINGLE_SCALAR);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    public static function getEmployeeBenefitById($id){
        $record=OhrmEmployeeBenefitsTable::getInstance()->findOneBy('id', $id);
        if($record){
            return $record;
        }
 else {
                        return NULL;}
    }
    
    
     public static function getEmpNumberFromBenefit($id) {
        try {
            return OhrmEmployeeBenefitsTable::getInstance()
                    ->createQuery()
  ->select()
  ->where(" `benefit_id`=$id")
  ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    



    public function deleteBenefit($id) {
        try {
             $deletequery=OhrmEmployeeBenefitsTable::getInstance()
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
            return  OhrmLoanChargesTable::getInstance()->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
