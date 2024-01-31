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

/**
 * Description of GraphDao
 */
class GraphDao {

    public function getEmployeeCountBySubUnit() {
        try {

            $q = "
                SELECT (
                        SELECT f.name
                        FROM ohrm_subunit f 
                        WHERE f.level = 1
                            AND f.lft <= c.lft and f.rgt >= c.rgt
                    ) AS sub_unit, 
                    COUNT(emp_number) AS emp_count
                FROM hs_hr_employee e
                LEFT JOIN ohrm_subunit c 
                ON e.work_station = c.id
                WHERE (e.termination_id IS NULL)
                GROUP BY sub_unit;  ";
            $pdo = Doctrine_Manager::connection()->getDbh();
            $stmt = $pdo->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_FUNC, array(__CLASS__, "SubunitFormatter"));
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

	
	public function getEmployeeCountByLocation() {
        try {

            $q = "
                SELECT c.NAME AS sub_unit, 
                    COUNT(e.emp_number) AS emp_count
                FROM hs_hr_emp_locations e
                LEFT JOIN ohrm_location c 
                ON e.location_id = c.id
				LEFT JOIN hs_hr_employee he
				ON e.emp_number = he.emp_number
                WHERE (he.termination_id IS NULL)
                GROUP BY sub_unit;";
            $pdo = Doctrine_Manager::connection()->getDbh();
            $stmt = $pdo->prepare($q);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_FUNC, array(__CLASS__, "LocationFormatter"));
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
	
	function LocationFormatter($subunitName, $count) {
        if (empty($subunitName)) {
            $subunitName = __("Not assigned to MDAs");
        }
        return array("name" => $subunitName, "COUNT" => $count);
    }
	
    function SubunitFormatter($subunitName, $count) {
        if (empty($subunitName)) {
            $subunitName = __("Not assigned to Departments");
        }
        return array("name" => $subunitName, "COUNT" => $count);
    }

}
