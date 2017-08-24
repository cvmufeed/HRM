<?php /* Smarty version 2.6.7, created on 2017-08-24 10:54:46
         compiled from common/common.tpl.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SimpleHRM - Open Source Human Resource Mnagement .::</title>

<?php echo '
<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/jquery.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/jquery.validate.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/jquery-ui.js"></script>
'; ?>

<?php if ($_REQUEST['choice'] != 'reminders'): ?>
<?php echo '
	<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/jquery-ui-1.7.1.custom.min.js"></script>
	<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/daterangepicker.jQuery.js"></script>
'; ?>

<?php endif; ?>
<?php echo '
<script type="text/javascript" src="http://localhost/simplehrm/libsext/fancybox/jquery.fancybox-1.3.2.pack.js"></script>

<!--[if IE]><script language="javascript" type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/excanvas.js"></script><![endif]-->

<script type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/flexymessage.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/jquery.autocomplete.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/ajaxfileupload.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/templates/flexyjs/scrollable.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/overlib.js"></script>


<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/fancybox/jquery.fancybox-1.3.2.css"/>
<!--<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/mainpg.css"/>-->
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/css/flexy.css"/>
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/css/flexymenu.css"/>
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/jquery-ui-1.7.3.css"/>
'; ?>

<?php if ($_REQUEST['choice'] != 'reminders'): ?>
<?php echo '
	<link href="http://localhost/simplehrm/templates/css_theme/ui.daterangepicker.css" rel="stylesheet">
	<link rel="stylesheet" href="http://localhost/simplehrm/templates/css_theme/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />
'; ?>

<?php endif; ?>

<?php $this->assign('lgouttime', $this->_tpl_vars['util']->get_values_from_config('FORCED_LOGOUT')); ?>
<?php echo '
<script type="text/javascript">
	var flag_act = 0;
	function check_JSsession(res,flag_act){
		if(res == "nosession") {	
			if(flag_act == 1)
				cHideActivity();
			window.location.href = "http://localhost/simplehrm/index.php/user/logout/noses-1";
		 }else {
			return true;
		 }
	 }

	var closeFancyBox = 0;	
	function show_fancybox(res){
		$("#fancybox-content").removeClass("bgactive");		
		$.fancybox(res,{
			padding:\'0px\',
			background:\'none\',
			centerOnScroll:true,
			hideOnOverlayClick:false,
			onCleanup : function(){
				var ch=checkChanges();
				if(ch && closeFancyBox != 2){
					closeFancyBox = 1;
					$( "#dialog:ui-dialog" ).dialog( "destroy" );
					$("#confmsg").html("Do you really want to close this dialog?");
					$("#dialog-confirm").dialog(\'open\');
					$( "#dialog-confirm" ).dialog({
						zIndex: 12148797,
						draggable: false,
						scrollParent:false,
						resizable: false,
						modal: true,
						buttons: {
							"Cancel": function() {
								$(this).dialog( "close" );
								$( "#dialog-confirm" ).dialog( "destroy" );
							 },
							"Close without saving": function() {
								closeFancyBox = 2;
								$(this).dialog( "close" );
								$( "#dialog-confirm" ).dialog( "destroy" );
								$.fancybox.close();
								if($("#forremind").val()==\'1\'){
									window.location.reload();
								 }
							 }
						 }
					 });				
					return false;
				 }else{
					$("#formdata").val(\'\');
					$("#formid").val(\'\');
					$.fancybox.close();
					if($("#forremind").val()==\'1\'){
						window.location.reload();
					 }
				 }
			 },
			onClosed : function(){
				//$(\'.range-start\').datepicker(\'destroy\');
				//$(\'.range-end\').datepicker(\'destroy\');				
				closeFancyBox = 0;
			 }
		 });		
	 }

	function nav_menu(){ //v1.1.0.2 by PVII-www.projectseven.com
	if(navigator.appVersion.indexOf("MSIE")==-1){
			return;
		 }
		var i,k,g,lg,r=/\\s*p7hvr/,nn=\'\',c,cs=\'p7hvr\',bv=\'p7menubar\';
		for(i=0;i<10;i++){
			g=document.getElementById(bv+nn);
			if(g){
				lg=g.getElementsByTagName("LI");
				if(lg){
					for(k=0;k<lg.length;k++){
						lg[k].onmouseover=function(){
							c=this.className;
							cl=(c)?c+\' \'+cs:cs;
							this.className=cl;
						 };
						lg[k].onmouseout=function(){
							c=this.className;
							this.className=(c)?c.replace(r,\'\'):\'\';
						 };
					 }
				 }
			 }
			nn=i+1;
		 }
	 }
	function get_next_page(url, start, limit, div_id) {
		cShowActivity(\'1\');
		if (!document.getElementById(div_id)) {
			div_id = "content";
		 }
		$.post(url,{\'qstart\':start, \'limit\':limit, \'ce\':0 ,chk:1,\'pg\':1 },function(response){
			if(check_JSsession(response,1)) {
				$("#target").html(\'\');
				document.getElementById(div_id).innerHTML=response;
				cHideActivity();					
			 }
		 });
	 }
	function editPhoto(){
		cShowActivity(\'\');
		var id = $.trim($("#upd_id").val());
		var url = "http://localhost/simplehrm/index.php/";
		$.post(url,{page:"employee",choice:"editPhoto",ce:0,id:id },function(res){
			show_fancybox(res);
		 });
	 }
	
	var id;
	function empDetail(id){
		cShowActivity(\'\');
		window.location=\'http://localhost/simplehrm/index.php/employee/employeeDetail/id-\'+id;
	 }
	function resetForm(chc){
		var url="http://localhost/simplehrm/index.php/employee/"+chc+"/id-"+$("#upd_id").val();
		$.post(url,{ce:0,left:0,right:0 },function(res){
			$("#container").html(res);
			editDetail();
		 });
	 }
	function editDetail(){
		$("#target").html(\'\');
		$(".edit_detail").addClass(\'temp\').removeClass(\'edit_detail\');
		$(".detail").addClass(\'edit_detail\');
	 }
	//show error message in case of multiple options for ajax update   -- ex:-config management
	function showmsg(id,msg){
		if(!id)
			id="errmsg";
		$(\'#\'+id).html(msg).css({\'position\':\'fixed\',\'top\':\'120px\',\'left\':\'450px\',\'zIndex\':\'10055\' }).show(\'0\');
		setTimeout("hidemsg(\'"+id+"\')",10000);
	 }
	function hidemsg(id){
		$(\'#\'+id).hide(\'slow\');
	 }
	
	//End show error message
	// To make background disabled when processing an input.
	var flag4active;
	function cShowActivity(flag4active){
		$.fancybox.showActivity();
		if(flag4active==\'1\'){
			$("#disable_back").addClass("disable_back");
		 }else if(flag4active==\'2\'){
			$("#disable_back").addClass("disable_back");
			$("#fancybox-content").addClass("bgactive");
			$("#fancybox-content input,textarea,select").attr(\'readonly\', \'readonly\');
			$("#fancybox-content input[type=\'button\'],button").attr(\'disabled\', \'disabled\');
			closeFancyBox = 2;
		 }
	 }
	function cHideActivity(){
		$.fancybox.hideActivity();
		$("#disable_back").removeClass("disable_back");
		$("#fancybox-content,div #container").removeClass("bgactive");
		$("input,textarea,select").removeAttr(\'readonly\');
		$("input[type=\'button\'],button").removeAttr(\'disabled\');
	 }
	// end of disbaled functions
	
	// Code for forced logout.
	timer();
	var x;
	function timer(){
		var iduser="';  echo $_SESSION['id_user'];  echo '";
		if(iduser){	
			var curtime = parseInt($(\'#lgout\').val())+1;
			var periods="';  echo $this->_tpl_vars['lgouttime']['second'];  echo '";
			if(curtime >= periods){
				window.location.href="http://localhost/simplehrm/index.php/user/logout/noses-1";
			 }else {
				$(\'#lgout\').val(curtime);
				x=setTimeout(\'timer()\',1000);
			 }
		 }else{
			return true;
		 }
	 }
	$(\'*\').click(function(){
		$(\'#lgout\').val(0);
	 });
	// End of forced logout

	// jquery confirm box.
	var fun=\'\';
	function jqueryConfirm(){
		var l=arguments.length;
		fun=arguments[1]+"(";
		for(var i=2; i<l; i++)
		    fun+="\'"+arguments[i]+"\',";
		fun+="\'1\')";
		$("#confmsg").html(arguments[0]);
		$("#dialog-confirm").dialog(\'open\');
		
		$( "#dialog-confirm" ).dialog({
			zIndex: 111999,
			draggable: false,
			scrollParent:false,
			resizable: false,
			modal: true,
			buttons: {
				"No": function() {
					$( this ).dialog( "close" );
					$( "#dialog-confirm" ).dialog( "destroy" );
					return false;
				 },
				"Yes": function() {
					$( this ).dialog( "close" );
					$( "#dialog-confirm" ).dialog( "destroy" );
					setTimeout(fun,10);
				 }
			 }
		 });
		return 0;
	 }
	// End of jquery confirm box
	// jquery alert box.

	function jqueryAlert(alertmsg){
		$("#alertmsg").html(alertmsg);
		$("#dialog-message").dialog(\'open\');
		$("#dialog-message").dialog({
			zIndex: 3999,
			draggable: false,
			resizable: false,
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				 }
			 }
		 });
	 }
	// End of jquery alert box
	function showmsg(id,msg){
		if(!id)
			var id="errmsg";
		if(msg)
			$(\'#\'+id).html(msg);
		//$(\'#\'+id).html(msg).css({\'zIndex\':\'10055\' }).show(\'slow\');
		$(\'#\'+id).css({\'position\':\'fixed\',\'left\':\'35%\',\'zIndex\':\'10055\' }).show(\'slow\');
		//.css({\'position\':\'fixed\',\'top\':\'120px\',\'left\':\'450px\',\'zIndex\':\'10055\' })
		setTimeout("hidemsg(\'"+id+"\')",3000);
	 }
	function hidemsg(id){
		$(\'#\'+id).hide(\'slow\');
		$("#target").removeClass("icon-msg");
	 }
	function callmsg(mesg){
		//alert(mesg);
		if(mesg){
			$("#target").addClass("icon-msg");
			showmsg("target",mesg);
		 }
	 }
	/* Close without saving code */
	function checkChanges(){
		if(closeFancyBox != 2){
			if($("#formid").val()==$("#formdata").val()){
				var curdata=\'\';
				var prevdata=\'\';
			 }else{
				var curdata=$($("#formid").val()).serialize();
				var prevdata=$("#formdata").val();
			 }
			if(curdata==prevdata){
				return false;
			 }else{
				return true;
			 }
		 }else{
			return false;
		 }
	 }
	function forminfo(formid){
		$("#formdata").val($(formid).serialize());
		$("#formid").val(formid);
	 }
	var z;
$(document).ready(function(){
	$(\'form#loginform\').find(\'table tr\').each(function(z){
		$(this).find(\'td:eq(1)\').css(\'text-align\',\'left\');
	 });
	$(\'table.listing_tbl tr td\').css(\'text-align\',\'left\');
	$(\'table.tbl_listing tr th:last\').css({
		borderRight:\'none\'
	 });
 });
	/* End of close without saving code */
</script>
<style>
	label.error	{
		color:#FF0000;
		font-size:10px;
		font-weight:normal;
	 }
	span.error	{
		color:#FF0000;
		font-size:12px;
	 }
	a{ border:0;text-decoration: none }
	a.cur{ font-weight:bold;  }
	.fcolor       {
		color:blue;
	 }
	.disable_back{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 200%;
		z-index: 1100;
		
	 }
	#target{
		color:#798C3A;
		font-weight:bold;
		font-size:14px;
	 }
	.icon-msg{
		border:solid 1px #798C3A;
		background:#EEF4DF url(img/icon-heart.png) 8px 6px no-repeat;
		color:red;
		padding:4px;
		text-align:center;
	 }
</style>

'; ?>

</head>
<body onload="nav_menu();">
<!-- For forced logout -->
<input type="hidden" name="logout" value="0" id="lgout">
<!-- For Jquery confirm box -->
<div id="dialog-confirm" title="Confirmation" style="display:none;font-weight:bold;">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;" ></span>
		<span id="confmsg"></span>
	</p>
</div>
<!-- For Jquery alert box -->
<div id="dialog-message" title="Alert" style="display:none;font-weight:bold;z-index:1100;">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 0px 0;"></span>
		<span id="alertmsg"></span>
	</p>
</div>
<div id="layer"></div>
<!-- For close without save -->
<input id="formdata" value="" type="hidden">
<input id="formid" value="" type="hidden">
<input id="forremind" value="0" type="hidden">
	<div id="mymodal"></div> 
	<div id="errmsg" class="errmsg"></div>
    
    
    
    
    
	<div id="page">
    
    
    
		<!-- Header part starts here -->
	 <div class="hdr">
    	<div class="page">
        	<div class="fltlft" style="width:660px;">
            	<div class="logo" ><a href="http://localhost/simplehrm/"><img src="http://localhost/simplehrm/templates/images/blue/logo1.png" height="37" width="300" /></a></div>
                 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/menucommon.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 </div>
                <?php if ($_SESSION['id_user']): ?>
                    <div class="logout_bg fltrht">
                        <div class="admin fltlft"><a href="http://localhost/simplehrm/index.php/employee/resetPwd"><img src="http://localhost/simplehrm/templates/images/blue/admin.png" height="36" width="36" /></a></div>
                        <div class="admin_txt fltlft"><a href="http://localhost/simplehrm/index.php/employee/resetPwd"><?php if ($_SESSION['firstname']):  echo $_SESSION['firstname'];  else:  echo $_SESSION['displayname'];  endif; ?><br /> Modify Profile</a></div>
                        <div class="logout fltlft"><a class="" href="http://localhost/simplehrm/index.php/user/logout"><img src="http://localhost/simplehrm/templates/images/blue/log_out.png" height="36" width="36" /></a></div>
                        <div class="logout_txt fltlft"><a class="" href="http://localhost/simplehrm/index.php/user/logout">LOG OUT</a></div>
                        <div class="clrbth"></div>
                    </div>
                <?php endif; ?>
             <div class="clrbth"></div>
        </div>
	</div>
 	<!-- Header part ends here -->
        
        <!-- Body Content Start -->
        		<div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/messages.tpl.html", 'smarty_include_vars' => array('module' => 'global')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
		<div id="container" align="center">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php if (! $_SESSION['id_user'] && ! $_REQUEST['page']): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user/loginForm.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
		</div>
        <!-- Body Content End -->

		<div class="clrbth"></div>
		<div class="push"></div>
	</div>
	<!-- Footer part starts here -->
	<div class="ftr_txt" align="center">&copy; Copyright 2011 SimpleHRM</div>
	<!-- Footer part ends here -->
</body>
</html>