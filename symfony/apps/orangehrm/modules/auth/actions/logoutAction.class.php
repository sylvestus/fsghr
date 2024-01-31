<?php

class logoutAction extends sfAction {

    /**
     * Logout action
     * @param $request 
     */
    public function execute($request) {
        $authService = new AuthenticationService();
        $authService->clearCredentials();
		
		//clear employee json file
		 $target_dir = sfConfig::get("sf_web_dir")."/employees.json";
		ftruncate($target_dir, 0);
//close file
fclose($target_dir);

		
             // header("Location: ../../../../../nurupala");
             // exit();
        $this->redirect('auth/login');
    }

}

