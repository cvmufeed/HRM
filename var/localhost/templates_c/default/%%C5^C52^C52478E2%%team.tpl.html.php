<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:08
         compiled from setting/team.tpl.html */ ?>
<div id="company_teamlisting"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "setting/teamlisting.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<?php echo '
<script type="text/javascript">
function remove_team(id,chc){
	var url="http://localhost/simplehrm/index.php/setting/removeteam/ce-0";
	if(chc==\'\'){
		chc=jqueryConfirm("Do you really want to delete this record?","remove_team",id);
	 }
	var qstart=$("#start").val();
	var cnt=$("#cnt").val();
	if(chc){
		cShowActivity(\'1\');
		$.post(url,{id_team:id,qstart:qstart,cnt:cnt },function(res){
			if(check_JSsession(res,1)) {
				cHideActivity();
				$(\'#setting_team\').html(res);
			 }
		 });
	 }else{
		return false;
	 }
 }
function addEditTeam(ch,id){
	var url="http://localhost/simplehrm/index.php/setting/addEditTeam/ce-0";
	cShowActivity(\'\');
	$.post(url,{ch:ch,id:id },function(res){
		if(check_JSsession(res,0)) {
			show_fancybox(res);
		 }
	 });
 }
</script>
'; ?>
