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

class approveAction extends  sfAction {
    
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
         if ($request->isMethod('post')) {
         $postarray= $request->getPostParameters();
        $ids=$postarray['ids'];
        $comment=$postarray['comment'];
         
		if ($user->isAdmin()) {
                    $id=$request->getParameter('audittrail');
       //update
       $tr=AuditTrailTable::getAuditTrailById($id);
      $conn = Doctrine_Manager::connection();
              //$sql = $conn->prepare($countQuery);
       // $result = $statement->execute($bindParams);
       foreach ($ids as $value) {
           
       
       $sql=$conn->prepare("UPDATE audit_trail SET approved_by=?,status=?,comments=? WHERE id=?");
$userid= $this->getUser()->getAttribute('user')->getUserId();
$status="approved";
$sql->bindParam(1,$userid);
$sql->bindParam(2,$status);
$sql->bindParam(3,$comment);
$sql->bindParam(4,$value);
//$sql->bindParam(6, "Leave assignment after payroll ".$monthyear);
$sql->execute(); 
       }
                    
          die('Transaction(s) successfully approved');           
                }
                else{
            die('An error occurred when updating transaction');      
                }
         
   
   $this->redirect('admin/approvals');
    }
    else{
        $this->getUser()->setFlash('error', __('Incorrect form parameters'));   
        $this->redirect('admin/approvals');
    }
}


}
