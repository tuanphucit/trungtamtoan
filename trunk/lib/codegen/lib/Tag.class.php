<?php
class Tag{
	public $content;
	public $tag;
	public $replace;
	public $params;
	
	function Tag($t,& $p){
		$this->init($t,$p);
	}
	
	function init($t,& $p){
		$this->replace = array();
		$this->tag = $t;
		$this->params = $p;
		$this->doStartTag();
	}
	
	function getContent(){
		return $this->content;
	}
	
	function doStartTag(){
		//get all the replace elements
		$this->replace = explode(",",$this->tag->getAttribute("replace"));
		/*if($this->tag->hasChildNodes){
			foreach(($this->tag->childNodes) as $e){
				switch($e->tagName){
					case "write":
						$child = new WriteTag($e,$this->params,$this->tag);
						$this->content .= $child->getContent();
						break;
					case "repeat":
						$child = new RepeatTag($e, $this->params, $this->tag);
						$this->content .= $child->getContent();
						break;
				}
			}
		}*/
		//else {
			$this->doTag();
		//}
	}
	function doTag(){}
}