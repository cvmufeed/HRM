<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:50
         compiled from user/companyDashboard.tpl.html */

$this->_cache_serials['/home/mufeed/html/generatedata/simplehrm/flexycms/../var/localhost/templates_c/default/%%1B^1B9^1B955BEE%%companyDashboard.tpl.html.inc'] = 'd55231b3a6453978727e7b2c2ff8f1b3';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_mod', 'user/companyDashboard.tpl.html', 43, false),array('modifier', 'date_format', 'user/companyDashboard.tpl.html', 79, false),)), $this); ?>
<?php
function _smarty_tplfunc_d55231b3a6453978727e7b2c2ff8f1b3_0(&$_smarty)
{
echo $_smarty->_plugins['function']['get_mod'][0][0]->get_mod(array('mod' => 'employee','mgr' => 'employee','choice' => 'latestAddModifyViewEmp'), $_smarty);
}


function _smarty_tplfunc_d55231b3a6453978727e7b2c2ff8f1b3_1(&$_smarty)
{
echo $_smarty->_plugins['function']['get_mod'][0][0]->get_mod(array('mod' => 'adminstration','mgr' => 'adminstration','choice' => 'reminderShow'), $_smarty);
}



?>
