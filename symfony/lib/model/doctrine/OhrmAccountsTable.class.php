<?php

/**
 * OhrmAccountsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class OhrmAccountsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object OhrmAccountsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('OhrmAccounts');
    }
    
    public static function getAccountById($value){
       try {
            return  self::getInstance()->find($value);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
}