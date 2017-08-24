<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:23
         compiled from employee/employeeSearch.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_mod', 'employee/employeeSearch.tpl.html', 24, false),)), $this); ?>
<?php $this->_cache_serials['/home/mufeed/html/generatedata/simplehrm/flexycms/../var/localhost/templates_c/default/%%28^289^28920114%%employeeSearch.tpl.html.inc'] = 'a0456d1545288836d82dba53025efda5'; ?>
<!-- Template: employee/employeeSearch.tpl.html Start 24/08/2017 10:53:23 --> 
 <table>
	<tr>
    		<td valign="top"><div id="employee_employeeList" class="mrgtp_16"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "employee/employeeList.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div></td>
    	<td>
        <div class="smlest_box">
		<div class="top"></div>
		<div class="mdl">
    			<div class="cont_hdr1 fltlft">
                    		<div class="cont_hdr_lft fltlft"></div>
                    		<div class="cont_hdr_mdl1 fltlft" align="left">Employee menu</div>
                    		<div class="cont_hdr_rht fltlft"></div>
                	</div>
        		<div class="clear"></div>	
        		<div class="a_cont wid84smlst">
                		<p><a href="http://localhost/simplehrm/index.php/leave/leaveRequest">Leave requests</a></p>
                		<p><a href="javascript:void(0);" onclick="searchEmployeeList('t','','','0');" id="a_terminate">Terminated employees</a></p>
        		</div>
    		</div>
		<div class="btm"></div>
	</div>
	<div id="latest_viewed">
		<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:a0456d1545288836d82dba53025efda5#0}';}echo $this->_plugins['function']['get_mod'][0][0]->get_mod(array('mod' => 'employee','mgr' => 'employee','choice' => 'latestAddModifyViewEmp','flag' => 'view'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:a0456d1545288836d82dba53025efda5#0}';}?>

	</div>
        </td>
    </tr>
</table>
<?php echo '
<script type="text/javascript">
	var f,emp_status=\'\';
	function searchEmployeeList(f,msg,k,qs){
		cShowActivity(\'1\');
		var url="http://localhost/simplehrm/index.php/employee/employeeList";
		if(qs===\'\'){
			qs=$("#qstart").val();
		 }
		// for terminated employee list
		if(f==\'t\'){
			f=\'\';
			emp_status=3;
			$("#employee_name").val(\'\');
			$("#a_terminate").css("font-weight","bold");
		 }
		// end
		var employee_name=$("#employee_name").val();
		$.post(url,{ce:0,chk:1,f:f,keys:k,msg:msg,qs:qs,emp_status:emp_status,employee_name:employee_name },function(res){
			if(check_JSsession(res,1)) {				
				$("#employee_employeeList").html(res);
				if(f == \'for_del\'){
					var url_lat ="http://localhost/simplehrm/index.php/employee/latestAddModifyViewEmp/flag-view";
					$.post(url_lat,{ce:0 },function(res_lat){
						$("#latest_viewed").html(res_lat);
					 });
				 }					
				cHideActivity();
			 }
		 });
	 }
</script>
<style type="text/css">
.cont_hdr{
	margin-top:15px;
 }
</style>
'; ?>


<!-- Template: employee/employeeSearch.tpl.html End --> 