<?php
include_once("WriteTag.class.php");
include_once("RepeatTag.class.php");
class TplReader{
	public $params; //hold the replacement of each element in the Template
	public $textClass;
	function TplReader(&$p){
		$this->params = $p;
	}
	
	//read an XML file
	function read($file){
		if (!file_exists($file)){
			die("can't found $file");
		}
		$dom = new DomDocument();
		$dom->load($file);
		foreach($dom->getElementsByTagName("class") as $classElement){
			$this->doClassTag($classElement);
		}
	}
	
	/*doClassTag:
	Process the "class" tag.
	*/
	function doClassTag($classElement){
		$this->textClass = "";
		foreach( ($classElement->childNodes) as $child){
			switch($child->nodeName){
				case "repeat":
					$repeatTag = new RepeatTag($child,$this->params);
					$this->textClass .= $repeatTag->getContent();
					break;
				case "write":
					$writeTag = new WriteTag($child,$this->params);
					$this->textClass .= $writeTag->getContent();
					break;
			}
		}
	}
	
	function getTextClass(){
		return $this->textClass;
	}
}
?>