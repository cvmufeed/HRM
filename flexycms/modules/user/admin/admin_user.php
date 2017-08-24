<?php
class admin_user extends user_manager {
	function admin_manager(& $smarty, & $_output, & $_input) {
		if($_SESSION['id_admin']){
			$this->user_manager($smarty, $_output, $_input, 'user');
			$this->obj_user = new user;
			$this->user_bl = new user_bl;
		}
	}
	function get_module_name() {
		return 'user';
	}
	function get_manager_name() {
		return 'user';
	}
}