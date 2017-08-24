<?php
class admin_report extends report_manager {
	
	function admin_report(& $smarty, & $_output, & $_input) {
		$this->report_manager($smarty, $_output, $_input, 'report');
		$this->obj_report = new report;
		$this->report_bl = new report_bl;
	}
	function get_module_name() {
		return 'report';
	}
	function get_manager_name() {
		return 'report';
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