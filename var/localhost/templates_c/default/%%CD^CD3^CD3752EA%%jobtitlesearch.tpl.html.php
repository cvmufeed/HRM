<?php /* Smarty version 2.6.7, created on 2013-09-09 08:16:11
         compiled from setting/jobtitlesearch.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'setting/jobtitlesearch.tpl.html', 22, false),)), $this); ?>

<!-- Template: setting/jobtitlesearch.tpl.html Start 09/09/2013 08:16:11 --> 
 <div class="cont">
	<div class="cont_bg_top"></div>
	<div class="cont_bg_mdl">
    	<div class="cont_hdr1 fltlft">
                    <div class="cont_hdr_lft fltlft"></div>
                    <div class="cont_hdr_mdl1 fltlft" align="left">Search</div>
                    <div class="cont_hdr_rht fltlft"></div>
                </div>
        <div class="clear"></div>
        <div style="padding:0px 40px;">
        <table width="100%">
        	<form name="jobtitle_searchform" id="jobtitle_searchform" method="post" action="javascript:void(0);"> 
        	<tr>
            	<td width="50%">
                	<table class="listing_tbl">
            <tr>
            	<td width="30%">Division name:</td>
                <td width="70%"><select name="id_division" id="div_name">
						    	<option value="">All</option>
						    	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['div']), $this);?>
 
					      	</select></td>
            </tr>
            <tr>
            	<td>Department name:</td>
                <td><select name="id_department" id="dept_name">
					    		<option value="">All</option> 
							<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['dept1']), $this);?>

						</select></td>
            </tr>
        </table>
                </td>
                <td width="50%">
                	<table class="listing_tbl">
            <tr>
            	<td>Team name:</td>
                <td><select name="id_team" id="id_team">
					    		<option value="">All</option> 
							<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['team1']), $this);?>

						</select></td>
            </tr>
            <tr>
            	<td>Job title:</td>
                <td><input name="job_title_name" type="text" id="job_title_name"/></td>
            </tr>
        </table>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td><input name="search" id="search" type="button" value="Search" onclick="search_jobtitle();" class="login_btn"></td>
            </tr>
            </form>
        </table>	
        </div>
    </div>
	<div class="cont_bg_btm"></div>
</div>
<div id="company_jobtitlelisting"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "setting/jobtitleslisting.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php echo '
<script type="text/javascript">
	$(document).ready(function(){
		$("#job_title_name").autocomplete("http://localhost/SHRMV22/index.php/setting/findjobtitlename/ce-0-dept-deptname-for-norauto?",{delay: 50 });
		$("#job_title_name").result(function(event, data, formatted) {
			if(data) {
				$(\'#job_title_name\').val(data[1]);
		 	 }
 });	
	 });
	function search_jobtitle(){
		cShowActivity(\'1\');
		var url1=$(\'#jobtitle_searchform\').serialize(); //searchform  id the form name
		var url2="http://localhost/SHRMV22/index.php/setting/jobtitles/ce-0-?";
		var url=url2+url1;
		$.post(url,{chk:1 },function(res){
			if(check_JSsession(res,1)) {
				$(\'#setting_jobtitles\').html(res);
				cHideActivity();
			 }
		 });
		return false;
	 }
	function show_Department(){
		var id_div=$("#div_name").val();
		var status=$(\'#status\').val();
		var url="http://localhost/SHRMV22/index.php/setting/getdeptName/ce-0-?";
		$.post(url,{id_division:id_div },function(res){
			if(check_JSsession(res,0)) {
				$(\'#dept_name\').html(res);
				$(\'#id_team\').html(\'<option value="">All</option>\');
			 }
		 });
	 }
	function show_Team(){
		var id_dept=$(\'#dept_name\').val();
		var status=$(\'#status\').val();
		var url="http://localhost/SHRMV22/index.php/setting/getteamName/ce-0-?";
		$.post(url,{id_department:id_dept },function(res){
			if(check_JSsession(res,0)) {
				$(\'#id_team\').html(res);
			 }
		 });
	 }
	function remove_jobtitle(id,chc){
		var url1=$(\'#jobtitle_searchform\').serialize(); 
		var url2="http://localhost/SHRMV22/index.php/setting/remove_jobtitle/ce-0?";
		var url=url2+url1;
		if(chc==\'\'){
			chc=jqueryConfirm("Do you really want to delete this job title?","remove_jobtitle",id);
		 }
		var qstart=$("#start").val();
		var cnt=$("#cnt").val();
		if(chc){
			cShowActivity(\'1\');
			$.post(url,{id_job_title:id,qstart:qstart,cnt:cnt,chk:1 },function(res){
				if(check_JSsession(res,1)) {
					$(\'#setting_jobtitles\').html(res);
					cHideActivity();
				 }
			 });
		 }else{
			return false;
		 }
	 }
	function edit_jobtitles(id_jobtitle,jobtitlesname,id_team,div_name,dept_name,team_name,note,id_dep,id_div){
		var url="http://localhost/SHRMV22/index.php/setting/editjobtitle/ce-0-?";
		cShowActivity(\'\');
		$.post(url,{id_jobtitle:id_jobtitle,jobtitlesname:jobtitlesname,id_team:id_team,div_name:div_name,dept_name:dept_name,team_name:team_name,notes:note,id_department:id_dep,id_division:id_div },function(res){
			if(check_JSsession(res,0)) {
				show_fancybox(res);
			 }
		 });
	 }
	function addjobtitle(){
		var url="http://localhost/SHRMV22/index.php/setting/addjobtitle/ce-0-?";
		cShowActivity(\'\');
		$.post(url,{ },function(res){
			if(check_JSsession(res,0)) {
				show_fancybox(res);
			 }
		 });
	 }
</script>
'; ?>




<!-- Template: setting/jobtitlesearch.tpl.html End --> 