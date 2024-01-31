<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class interviewsAction extends sfAction {

    /**
     *
     * @param <type> $request 
     */
    public function execute($request) {

     
      
       $this->pager = new sfDoctrinePager('Ohrm_Interview', sfConfig::get('app_max_jobs_on_homepage'));
        $this->pager->setQuery(Doctrine::getTable('Ohrm_Interview')->createQuery('a')->orderBy('a.interview_date DESC'));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();	

}

}