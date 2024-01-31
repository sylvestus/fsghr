<?php

/**
 * OhrmBudgetsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class OhrmBudgetsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object OhrmBudgetsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('OhrmBudgets');
    }
    
    public static function getAllBudgets(){
        try {
        return Doctrine_Query::create()->from ('OhrmBudgets')
             ->where(" `id`> 0") 
                ->orderBy("name ASC")
      ->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
     public static function getBudget($id){
        return self::getInstance()->find($id);
    }
    
}