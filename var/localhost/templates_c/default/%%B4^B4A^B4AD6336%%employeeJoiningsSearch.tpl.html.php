<?php /* Smarty version 2.6.7, created on 2017-08-24 10:54:38
         compiled from report/employeeJoiningsSearch.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select_date', 'report/employeeJoiningsSearch.tpl.html', 10, false),)), $this); ?>

<!-- Template: report/employeeJoiningsSearch.tpl.html Start 24/08/2017 10:54:38 --> 
 <div align="center">
<table border="0" width="40%">
    <tr>
        <td align="center" valign="middle">
            <b></b>
        </td>
        <td>
            <?php echo smarty_function_html_select_date(array('start_year' => 1900,'display_days' => false,'reverse_years' => true,'month_empty' => 'All months','year_empty' => 'All years','month_extra' => "id='search_month'",'year_extra' => "id='search_year'"), $this);?>

        </td>
        <td valign="center">
            <input type="button" name="search" value="Search" onclick="searchEmployeeJoiningsList('','','','0');" class="login_btn">
        </td>
    </tr>
</table>
</div>
<div id="report_employeeJoinings"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "report/employeeJoiningsList.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php echo '
<script type="text/javascript">
	$("body #container").ready(
		function(){
			$(this).find(\'select:first\').val("");
			$(this).find(\'select:last\').val("");
		 }
	);
	function searchEmployeeJoiningsList(f,msg,k,qs){
		cShowActivity(\'1\');
		var url="http://localhost/simplehrm/index.php/page-report-choice-employeeJoinings";
		var m=$("#search_month").val();
		var y=$("#search_year").val();
		if(qs===\'\'){
			qs=$("#qstart").val();
		 }
		var sal_range = $("#sal_range").val();
		$.post(url,{ce:0,chk:1,qs:qs,m:m,y:y },function(res){
			$("#report_employeeJoinings").html(res);
			cHideActivity();
		 });
	 }
</script>
'; ?>


<!-- Template: report/employeeJoiningsSearch.tpl.html End --> 