<?php
class WriteTag extends Tag{
	function WriteTag($t,& $p){
		$this->init($t,$p);
	}
	
	function doTag(){
		$this->content = $this->tag->textContent;
		foreach($this->replace as $rep){
			if (isset($this->params[$rep])){
				$this->content = str_replace("%$rep%",$this->params[$rep],$this->content);
			}
		}
	}
}