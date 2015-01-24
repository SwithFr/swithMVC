<?php

namespace App\Controllers;
use Core\Controllers as CC;

class AppController extends CC\Controller{
	
	/**
	 * Fonction optionnelle qui est exécutée (seulement si définie) avant de rendre la vue
	 * CF : Dispatcher
	 */
	public function beforeRender(){
		if(isset($this->request->prefixe) && $this->request->prefixe == "admin"){
			if($this->Auth->role() != "admin"){
				$this->redirect("users/login");
			}else{
				$this->layout = 'admin';
			}
		}
	}

}