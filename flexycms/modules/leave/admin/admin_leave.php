<?php
class admin_leave extends leave_manager {
	function admin_leave(& $smarty, & $_output, & $_input) {
		if($_SESSION['id_admin']){
			$this->leave_manager($smarty, $_output, $_input, 'leave');
			$this->obj_leave = new leave;
			$this->leave_bl = new leave_bl;
		}
	}
	function get_module_name() {
		return 'leave';
	}
	function get_manager_name() {
		return 'leave';
	}
	
		function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			print "<h1>This url is not meaningfull</h1>";
		}
	}
	function _clear_all() {
		echo VAR_DIR."cache<br>";
		echo VAR_DIR."captcha_cache<br>";
		echo VAR_DIR."templates_admin_c<br>";
		echo VAR_DIR."templates_c<br>";
	}
}
