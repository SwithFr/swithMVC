<?php

namespace App\Controllers;

class PagesController extends AppController{

	public function index(){
		$this->layout = "home";
	}

	public function doc(){
		$this->loadModel('Doc');
		$doc = $this->Doc->getFirst(['fields'=>'*','where'=>["type"=>"doc"]]);
		$this->set('doc',$doc);
	}

}