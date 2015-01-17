<?php

namespace App\Controllers;

class DocsController extends AppController{

	public $layout = "admin";

	function admin_index(){
		$d['perPage'] = 2;
		$d['total'] = $this->Doc->count();
		$d['nbPages'] = ceil($d['total'] / $d['perPage']);
		$d['docs'] = $this->Doc->get(
			[
				'offset'=> $d['perPage'] * ($this->request->page - 1),
				'limit' => $d['perPage']
			]
		);
		$this->set($d);
	}
	
	function admin_add(){
		if($this->request->isPost){
			$this->Doc->create($this->request->data);
			$this->redirect("admin/docs/adminndex");
		}
	}	

	function admin_edit($id){
		if(is_null($id)){
			$this->error('Parametre manquant');
		}
		$doc = $this->Doc->getFirst(['fields'=>'*','where'=>['id'=>$id]]);
		$this->set("doc",$doc);
	}

	function admin_goEdit($id){
		$this->needRender = false;
		if($this->request->isPost)
			$this->request->data['about'] = addslashes($this->request->data['about']);
			$this->request->data['content'] = addslashes($this->request->data['content']);
			$this->Doc->updateData($id,$this->request->data);
		$this->redirect("admin/docs/edit/".$id);
	}

	function admin_delete($id){
		$this->needRender = false;
		$this->Doc->delete($id);
		$this->redirect("admin/docs/index");
	}

}