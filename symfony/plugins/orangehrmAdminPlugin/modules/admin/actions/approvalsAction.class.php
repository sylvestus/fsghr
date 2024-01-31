<?php
/*
 *
 * TechSavannaHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 TechSavannaHRM Inc., http://www.techsavanna.technology
 *

 *
 * TechSavannaHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

class approvalsAction extends  sfAction {
    
    protected $homePageService;
    
    public function getHomePageService() {
        
        if (!$this->homePageService instanceof HomePageService) {
            $this->homePageService = new HomePageService($this->getUser());
        }
        
        return $this->homePageService;
        
    }

    public function setHomePageService($homePageService) {
        $this->homePageService = $homePageService;
    }    

    public function execute($request) {
//limit to admin
        $user = $this->getUser()->getAttribute('user');
        
		if ($user->isAdmin()) {
        $this->trails=  AuditTrailTable::getGroupedAuditTrail(0,1000);
                }
                else{
            $this->trails=null;        
                }
        
    }

}
