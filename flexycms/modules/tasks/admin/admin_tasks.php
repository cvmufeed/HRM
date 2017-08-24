<?php
class admin_tasks extends tasks_manager {
	function admin_tasks(& $smarty, & $_output, & $_input) {
		if($_SESSION['id_admin']){
			$this->tasks_manager($smarty, $_output, $_input, 'tasks');
			$this->obj_tasks = new tasks;
			$this->tasks_bl = new tasks_bl;
		}
	}
	function get_module_name() {
		return 'tasks';
	}
	function get_manager_name() {
		return 'tasks';
	}
	function _clear_all() {
		echo VAR_DIR."cache<br>";
		echo VAR_DIR."captcha_cache<br>";
		echo VAR_DIR."templates_admin_c<br>";
		echo VAR_DIR."templates_c<br>";
	}
}
?>
