<?php

/**
 * OhrmBankTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class OhrmBankTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object OhrmBankTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('OhrmBank');
    }
	
	 public static function  getBankById($id){
           
             $q = Doctrine_Query::create()
                            ->from('OhrmBank')
                         ->where(" `id`=$id");
  
            $q->execute();
 $salary=$q->fetchOne();
 if(is_object($salary)){
 return $salary;
 }else{
     return null;
 }
    }
}