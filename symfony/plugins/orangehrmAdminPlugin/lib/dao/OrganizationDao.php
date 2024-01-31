<?php

/**
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *
 * TechSavannaHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class OrganizationDao extends BaseDao {

    public function getOrganizationGeneralInformation() {
        try {
            return Doctrine :: getTable('Organization')->find(1);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    
     public function getOrganizationInformation() {
        try {
              $organizationinfo = Doctrine_Query::create()
                            ->from('Organization')
                            ->where('id = ?',1)
                                              ->fetchArray();  
          
              
           return $organizationinfo[0];
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    
    public static function isDateGreater($biggerdate,$smallerdate){
        $monthforbiggerdate=substr($biggerdate,0,2);
          $monthforsmallerdate=substr($smallerdate,0,2);
         
          $yearforbiggerdate = substr($biggerdate,-4);  
           $yearforsmallerdate = substr($smallerdate,-4);  
          //comparisons
           
           //this is given
           if($yearforbiggerdate > $yearforsmallerdate){
               return TRUE;
           }
           //if both years are equal but months different
           else if(($yearforbiggerdate==$yearforsmallerdate) && ($monthforbiggerdate > $monthforsmallerdate)){
             
                   return TRUE;
              
           }
           else {
               return FALSE;
           }
           
          
    }
    
     public static function isDateGreaterOrEqualTo($biggerdate,$smallerdate){
         $monthforbiggerdate=substr($biggerdate,0,2);
          $monthforsmallerdate=substr($smallerdate,0,2);
         
          $yearforbiggerdate = substr($biggerdate,-4);  
           $yearforsmallerdate = substr($smallerdate,-4);  
          //comparisons
           
           //greater than
           if($yearforbiggerdate > $yearforsmallerdate){
               return TRUE;
           }
           //equal to
           else if(($yearforbiggerdate==$yearforsmallerdate) && ($monthforbiggerdate >=$monthforsmallerdate)){
             
                   return TRUE;
            
           }
           else {
               return FALSE;
           }
           
          
    }
     public static function isDateEqualTo($biggerdate,$smallerdate){
        $monthforbiggerdate=substr($biggerdate,0,2);
          $monthforsmallerdate=substr($smallerdate,0,2);
         
          $yearforbiggerdate = substr($biggerdate,-4);  
           $yearforsmallerdate = substr($smallerdate,-4);  
          //comparisons
           
           //greater than
           if(($yearforbiggerdate==$yearforsmallerdate) && ($monthforbiggerdate ==$monthforsmallerdate) ){
               return TRUE;
           }
           
           else {
               return FALSE;
           }
           
          
    }

    public static function isDateLesserOrEqualTo($biggerdate,$smallerdate){
         $monthforbiggerdate=substr($biggerdate,0,2);
          $monthforsmallerdate=substr($smallerdate,0,2);
        
          $yearforbiggerdate = substr($biggerdate,-4);  
           $yearforsmallerdate = substr($smallerdate,-4);  
           
          //comparisons
           
           //greater than eg 2015 <2016 not 2015==2015 as 2015-11 !< 2015-12
        
           if($yearforbiggerdate < $yearforsmallerdate ){
              
               return TRUE;
               
           }
           //equal to
           else if(($yearforbiggerdate==$yearforsmallerdate) && ($monthforbiggerdate <=$monthforsmallerdate)){
            
                   return TRUE;
            
           }
           else {
               return FALSE;
           }
           
          
    }
}

