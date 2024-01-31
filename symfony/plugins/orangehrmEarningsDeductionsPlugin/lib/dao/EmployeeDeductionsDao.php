<?php

class EmployeeDeductionsDao extends BaseDao {

     public static function getDeductionByEmpNumber($empno) {
        try {
            return OhrmEmpsalaryDeductionsTable::getInstance()
                    ->createQuery()
  ->select()
  ->where(" `emp_number`=$empno")
  ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    //sum of deductions
    public static function getEmployeeDeductionsSumForMonth($empno,$yearmonth) {
   
        $results=Doctrine::getTable('OhrmEmpsalaryDeductions')
  ->createQuery()
  ->select("SUM(amount)")
  ->where(" `emp_number`=$empno")
  ->andWhere("DATE_FORMAT(`deduction_date`,'%Y-%m')='$yearmonth'")
     ->fetchArray();
return $results[0]["SUM"];
    }
    
    
    public static function getEmployeeDeduction($empno,$id) {
        try {
        return Doctrine_Query::create()->from ('OhrmEmpsalaryDeductions')
       ->select("id")
      ->where(" `deduction`=$id")
      ->andWhere(" `emp_number`=$empno")
          ->fetchOne(array(),  Doctrine::HYDRATE_SINGLE_SCALAR);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
        //deductions for month
     public static function getEmployeeDeductionsForMonth($empno,$yearmonth) {
    
        $results=OhrmEmpsalaryDeductionsTable::getInstance()
  ->createQuery()
  ->select("*")
  ->where(" `emp_number`=$empno")
  ->andWhere("DATE_FORMAT(`deduction_date`,'%Y-%m')='$yearmonth'")
 ->orWhere(" `is_recurrent`=1 AND `emp_number`='$empno'")               
   ->execute();
return $results;
    }
    
    public static function getEmployeeDeductionById($id){
        $record= OhrmEmpsalaryDeductionsTable::getInstance()->findOneBy('id', $id);
        if($record){
            return $record;
        }
 else {
                        return NULL;}
    }
    
    
     public static function getEmpNumberFromDeduction($id) {
        try {
            return OhrmEmpsalaryDeductionsTable::getInstance()
                    ->createQuery()
  ->select()
  ->where(" `deduction`=$id")
  ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    //get deduction from id and emp no
public static function getEmpNumberAndDeduction($empno,$id) {
       $q = Doctrine_Query::create()
                            ->from('OhrmEmpsalaryDeductions')
                       ->where(" `deduction`=$id")
                     ->andWhere(" `emp_number`=$empno");
             $q->execute();
             $results=$q->fetchOne();
            
         
        if($results) {
            return $results;
        } 
        else{
            return NULL;
        }
       
    }


    public function deleteDeduction($id) {
        try {
             $deletequery=  OhrmEmpsalaryDeductionsTable::getInstance()
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
            return  OhrmEmpsalaryDeductionsTable::getInstance()->getTree();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}
