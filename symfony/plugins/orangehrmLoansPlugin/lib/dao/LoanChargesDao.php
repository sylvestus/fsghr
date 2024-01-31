<?php

class LoanChargesDao extends BaseDao {

     public static function getLoanCharges() {
        try {
            return OhrmLoanChargesTable::getInstance()->findAll();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    public function getChargeById($id) {
        try {
            return  OhrmLoanChargesTable::getInstance()->find($id);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }



    public function deleteCharge($id) {
        try {
             $deletequery=  OhrmLoanChargesTable::getInstance()
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
