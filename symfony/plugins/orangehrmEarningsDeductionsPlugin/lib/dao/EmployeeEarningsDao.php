<?php

class EmployeeEarningsDao extends BaseDao {

     public static function getEarningByEmpNumber($empno) {
        try {
            return OhrmEmployeeEarningsTable::getInstance()
                    ->createQuery()
  ->select()
  ->where(" `emp_number`=$empno")
  ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    public static function getEmployeeEarning($empno,$id) {
        try {
        return Doctrine_Query::create()->from ('OhrmEmployeeEarnings')
       ->select("id")
      ->where(" `earning_id`=$id")
      ->andWhere(" `emp_number`=$empno")
          ->fetchOne(array(),  Doctrine::HYDRATE_SINGLE_SCALAR);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
      //get employee earnings
     public static function getEmployeeEarningsForMonth($empno,$yearmonth) {
   
        $results=Doctrine::getTable('OhrmEmployeeEarnings')
  ->createQuery()
  ->select("*")
  ->where(" `emp_number`=$empno")
  ->andWhere("DATE_FORMAT(`earnings_date`,'%Y-%m')='$yearmonth'")
   ->andWhere(" `active`=1")
  ->execute();
return $results;
    }
    
    public static function getEmployeeEarningsSumForMonth($empno,$yearmonth) {
   
        $results=Doctrine::getTable('OhrmEmployeeEarnings')
  ->createQuery()
  ->select("SUM(amount)")
  ->where(" `emp_number`=$empno")
  ->andWhere("DATE_FORMAT(`earnings_date`,'%Y-%m')='$yearmonth'")
   ->andWhere(" `active`=1")
  ->fetchArray();
return $results[0]["SUM"];
    }
    
    public static function getEmployeeEarningById($id){
        $record=OhrmEmployeeEarningsTable::getInstance()->findOneBy('id', $id);
        if($record){
            return $record;
        }
 else {
                        return NULL;}
    }
    
    
     public static function getEmpNumberFromEarning($id) {
        try {
            return OhrmEmployeeEarningsTable::getInstance()
                    ->createQuery()
  ->select()
  ->where(" `earning_id`=$id")
  ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
   
    public static function getEmpNumberAndEarning($empno,$id) {
       $q = Doctrine_Query::create()
                            ->from('OhrmEmployeeEarnings')
                       ->where(" `earning_id`=$id")
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



    public function deleteEarning($id) {
        try {
             $deletequery=OhrmEmployeeEarningsTable::getInstance()
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
