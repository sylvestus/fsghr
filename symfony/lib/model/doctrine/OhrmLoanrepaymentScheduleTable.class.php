<?php

/**
 * OhrmLoanrepaymentScheduleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class OhrmLoanrepaymentScheduleTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object OhrmLoanrepaymentScheduleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('OhrmLoanrepaymentSchedule');
    }
    
    
  public static function getMonthPrinciple($loanacct,$yearmonth){
    
       try {
             return Doctrine_Query::create()->from('OhrmLoanrepaymentSchedule')->where("`loanacct`='$loanacct'")->andWhere("DATE_FORMAT(date,'%Y-%m') ='$yearmonth'")->fetchOne();
            //return  OhrmLoanaccountsTable::getInstance()->find(
        } catch (Exception $e) {
            return 0;
        }
  }  
  
  public static function getLoanSchedule($loanacct){
    
       try {
         
             return Doctrine_Query::create()->from('OhrmLoanrepaymentSchedule')->where("`loanacct`='$loanacct'")->execute();
            //return  OhrmLoanaccountsTable::getInstance()->find(
        } catch (Exception $e) {
            return 0;
        }
  }  
  
   public static function getMonthlySchedule($id){
    
       try {
            $schedule=Doctrine_Query::create()->from('OhrmLoanrepaymentSchedule')->where("`id`='$id'")->fetchOne();
            return $schedule;
            //return  OhrmLoanaccountsTable::getInstance()->find(
        } catch (Exception $e) {
            return 0;
        }
        }
        
         public static function getLastMonth($loanacct){
    
       try {
            $schedule=Doctrine_Query::create()->from('OhrmLoanrepaymentSchedule')->where("`loanacct`='$loanacct'")->orderBy("id DESC")->limit(1)->fetchOne();
            return $schedule->getDate();
            //return  OhrmLoanaccountsTable::getInstance()->find(
        } catch (Exception $e) {
            return 0;
        }
        }
    public static function getSingleLoanSchedule($loanacct){
    
       try {
            $schedule=Doctrine_Query::create()->from('OhrmLoanrepaymentSchedule')->where("`loanacct`=$loanacct")->fetchOne();
            return $schedule->id;
            //return  OhrmLoanaccountsTable::getInstance()->find(
        } catch (Exception $e) {
            return 0;
        }
  }  
  
   public static function deleteSchedule($loanacctid) {
       if(self::getSingleLoanSchedule($loanacctid)){
          
        try {
             $deletequery=  self::getInstance()
  ->createQuery()
  ->delete()
  ->where(" `loanacct`=$loanacctid")
  ->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
   }
    public static function deleteMonthSchedule($id) {

        try {
             $deletequery=  self::getInstance()
  ->createQuery()
  ->delete()
  ->where(" `id`=$id")
  ->execute();
            return true;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }

   }
}