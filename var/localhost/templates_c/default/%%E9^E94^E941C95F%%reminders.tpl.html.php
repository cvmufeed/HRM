<?php /* Smarty version 2.6.7, created on 2017-08-24 10:49:26
         compiled from adminstration/reminders.tpl.html */ ?>

<!-- Template: adminstration/reminders.tpl.html Start 24/08/2017 10:49:26 --> 
 <div id="reminderSection">
<!--	<div id="addReminder">
			</div>
-->	<div id="adminstration_reminders">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "adminstration/reminderListing.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
</div>
<?php echo '
<script type="text/javascript">
function createics(){
	window.location.href = "http://localhost/simplehrm/index.php/adminstration/reminderIcs/ce-0";
 }
</script>
'; ?>


<!-- Template: adminstration/reminders.tpl.html End --> 