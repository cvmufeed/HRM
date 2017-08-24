<?php
class admin_employee extends employee_manager {
	
	function admin_employee(& $smarty, & $_output, & $_input) {
		$this->employee_manager($smarty, $_output, $_input, 'employee');
		$this->obj_employee = new employee;
		$this->employee_bl = new employee_bl;
	}
	function get_module_name() {
		return 'employee';
	}
	function get_manager_name() {
		return 'employee';
	}
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			print "<h1>This url is not meaningfull</h1>";
		}
	}
}