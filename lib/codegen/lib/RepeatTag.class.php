<?php
class RepeatTag extends Tag{
	function RepeatTag($t,& $p){
		$this->init($t,$p);
	}
	
	function doTag(){
		$c = count($this->params[$this->replace[0]]);
		for($i = 0; $i < $c; $i++){
			$content = $this->tag->textContent;
			foreach($this->replace as $rep){
				$content = str_replace("%$rep%",$this->params[$rep][$i],$content);
			}
			$this->content .= $content;
		}
	}
}