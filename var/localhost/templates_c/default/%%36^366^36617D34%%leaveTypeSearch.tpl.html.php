<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:53
         compiled from leave/leaveTypeSearch.tpl.html */ ?>

<!-- Template: leave/leaveTypeSearch.tpl.html Start 24/08/2017 10:50:53 --> 
 <table border="0">
	<tr>
		<td colspan="3" align="center" height="30">
			<b>Leave type name: </b>
			<input type="text" name="leave_type_name" id="leave_type_name" autocomplete="off" value=""/>
			<input type="button" name="search" id="search"  value="Search" onclick="searchLeaveType('','','','0');"/>
		</td>
	</tr>
	<tr>
		<td width="80%">
			<div id="leave_leaveTypes"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "leave/leaveType.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
		</td>
	</tr>
</table>
<?php echo '
<script type="text/javascript">
	function searchLeaveType(f,msg,k,qs){
		cShowActivity(\'1\');
		$("#target").html(\'\');
		var url="http://localhost/simplehrm/index.php/page-leave-choice-leaveTypes";
		if(qs===\'\'){
			var qs=$("#qstart").val();
		 }
		var leave_type_name=$("#leave_type_name").val();
		$.post(url,{ce:0,chk:1,qs:qs,leave_type_name:leave_type_name },function(res){
			$("#leave_leaveTypes").html(res);
			cHideActivity();
		 });
	 }
</script>
'; ?>


<!-- Template: leave/leaveTypeSearch.tpl.html End --> 