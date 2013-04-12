<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

require_once CGS_SYSTEM_PATH.'cgs.database.php';
class DefaultArticleBase extends CgsDatabase {
	protected $__conn = 'default';
	protected $__tbl = 'article';
	protected $__prefix = '';
	public $field = '*';
	function __construct(){
		parent::__construct();
		$this->setProperty('default');
	}
	
	function getTbl() {
		return $this->__prefix . $this->__tbl;
	}
	
	function getListAll($field='*'){
		return $this->select($this->getTbl(), $field,null,'updatetime DESC');
	}
	
	function getRow($id=0,$field='*'){
		settype($id, 'int');
		return $this->selectOne($this->getTbl(), $field, "`article_id`={$id}");
	}
	
	function updateId($id=0,$data=array()){
		settype($id, 'int');
		return $this->update($this->getTbl(), $data, "`article_id`={$id}");
	}
	
	function deleteById($id){
		settype($id, 'int');
		return $this->delete($this->getTbl(), "`article_id`={$id}");
	}
	
	
} // end class
