<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:55
         compiled from leave/leaveRequestSearch.tpl.html */ ?>

<!-- Template: leave/leaveRequestSearch.tpl.html Start 24/08/2017 10:50:55 --> 
 <?php $this->assign('emp_sts', $this->_tpl_vars['util']->get_values_from_config('EMPLOYMENT_STATUS')); ?>
<?php if ($_SESSION['id_company']): ?>
<table>
	<tr>
    		<td>			
			<div id="leave_leaveRequest" class="mrgtp_16"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "leave/leaveRequestList.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
		</td>
	</tr>
</table>
<?php else: ?>
	<div id="leave_leaveRequest"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "leave/leaveRequestList.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php endif; ?>
<?php echo '
<script type="text/javascript">
	var f;
	function searchLeaveRequest(f,msg,k,qs){
		cShowActivity(\'1\');
		var url="http://localhost/simplehrm/index.php/page-leave-choice-leaveRequest";
		// for filter on Leave status
		var leavestatus=\'\';
		$(\'.leavestatus\').each(function(){
			if($(this).is(\':checked\'))
				leavestatus+=","+$(this).val();
		 });
		if(leavestatus == \'\')
			leavestatus=",1";
		if(qs===\'\'){
			var qs=$("#qstart").val();
		 }
		$.post(url,{ce:0,chk:1,f:f,keys:k,msg:msg,qs:qs,leavestatus:leavestatus },function(res){
			$("#leave_leaveRequest").html(res);
			cHideActivity();
		 });
	 }
	function searchEmployeeList(f,msg,k,qs){
		$("#a_terminate").css("font-weight","bold");
		cShowActivity(\'1\');
		var url="http://localhost/simplehrm/index.php/page-employee-choice-employeeList";
		$.post(url,{ce:0,f:f,emp_status:"1",Tchk:1 },function(res){
			$("#container").html(res);
			cHideActivity();
		 });
	 }
</script>
'; ?>


<!-- Template: leave/leaveRequestSearch.tpl.html End --> 