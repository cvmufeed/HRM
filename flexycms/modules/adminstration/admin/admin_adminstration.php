<?php
class admin_adminstration extends adminstration_manager {
	function admin_manager(& $smarty, & $_output, & $_input) {
		if($_SESSION['id_admin']){
			$this->adminstration_manager($smarty, $_output, $_input, 'adminstration');
			$this->obj_adminstration = new adminstration;
			$this->adminstration_bl = new adminstration_bl;
		}
	}
	function get_module_name() {
		return 'adminstration';
	}
	function get_manager_name() {
		return 'adminstration';
	}
	function _clear_all() {
		echo VAR_DIR."cache<br>";
		echo VAR_DIR."captcha_cache<br>";
		echo VAR_DIR."templates_admin_c<br>";
		echo VAR_DIR."templates_c<br>";
	}
}
