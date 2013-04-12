<?php 
/**
 * General UI from XML
 * @author longhoangvnn
 *
 */
class CgsFormsView {
	public $view;
	
	function __construct($xml_path = null){
		// Nếu nhập $xml_path thì build UI
		$this->buildUi($xml_path);
	}
	
	function buildUi($xml_path = null){
		if (!is_null($xml_path)) {
			if (!$xml_path || !file_exists(CGS_XML_DATAS.$xml_path)){
				throw new CgsException($xml_path . ' : Không tồn tại!');
			}
			
			
			$viewName = pathinfo($xml_path, PATHINFO_FILENAME) . 'View';
			
			//if (!file_exists(CGS_UI_PATH . $viewName . '.php')){
				// Chay lenh sinh ui
				include_once CGS_CODEGEN_PATH . 'UiReader.php';
				$uiReader = new UiReader();
				$uiReader->source_path = CGS_XML_DATAS.$xml_path;
				$uiReader->out_path = CGS_UI_PATH;
				
				$uiReader->read();
			//}

			return true;
		}
		return;
	}
	
	function getView($viewName=''){
		if (!file_exists(CGS_UI_PATH . $viewName . '.php')){
			throw new CgsException($viewName . ' : Không tồn tại!');
		}
		
		include_once CGS_UI_PATH . $viewName . '.php';
		if (!class_exists($viewName)) {
			throw new CgsException('Không thể khởi tạo UI');
		}
		
		return new $viewName();
	}
	
	function set($name='', $value=NULL){
		return;
	}
	
	function getHtml($name=''){
		return $name;
	}
	
	function get($name){
		return $name;
	}
	
	function getHidden($name=''){
		return $name;
	}
	
	function getDisplay($name=''){
		return $name;
	}
}