<?php /* Smarty version 2.6.7, created on 2017-08-24 10:48:57
         compiled from report/employeeSalSearch.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report/employeeSalSearch.tpl.html', 9, false),)), $this); ?>

<!-- Template: report/employeeSalSearch.tpl.html Start 24/08/2017 10:48:57 --> 
 <table border="0">
	<tr>
		<td align="center" height="50">
			<b>Search on salary :</b>
			<select id="sal_range" name="sal_range" onchange="searchEmployeeSalList('','','','0');" style="width:20%">
			<option value="">-- All --</option>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['sal_ranges']), $this);?>

			</select>
		</td>
	</tr>
	<tr>
		<td width="100%">
			<div id="report_employeeSalary"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "report/employeeSalList.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
		</td>
	</tr>
</table>
<?php echo '
<script type="text/javascript">
	function searchEmployeeSalList(f,msg,k,qs){
		cShowActivity(\'1\');
		var url="http://localhost/simplehrm/index.php/page-report-choice-employeeSalary";
		if(qs===\'\'){
			qs=$("#qstart").val();
		 }
		
		var sal_range = $("#sal_range").val();
		$.post(url,{ce:0,chk:1,qs:qs,sal_range:sal_range },function(res){
			$("#report_employeeSalary").html(res);
			cHideActivity(\'\');
		 });
	 }
</script>
'; ?>


<!-- Template: report/employeeSalSearch.tpl.html End --> 