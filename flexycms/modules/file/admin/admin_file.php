<?php
class admin_files extends files_manager {
	
	function admin_files(& $smarty, & $_output, & $_input) {
		$this->files_manager($smarty, $_output, $_input, 'files');
		$this->obj_files = new files;
		$this->files_bl = new files_bl;
	}
	function get_module_name() {
		return 'files';
	}
	function get_manager_name() {
		return 'files';
	}
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			print "<h1>Put your own error handling code here</h1>";
		}
	}
}		

?>