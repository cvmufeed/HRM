<?php /* Smarty version 2.6.7, created on 2017-08-24 10:51:38
         compiled from employee/resetPwd.tpl.html */ ?>

<!-- Template: employee/resetPwd.tpl.html Start 24/08/2017 10:51:38 --> 
 <div class="smler_box">
	<div class="top"></div>

	<div class="mdl">
    	<div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft" align="left">Reset password</div>
            <div class="cont_hdr_rht fltlft"></div>
        </div>
        <div class="clear"></div>	
            <form class="basic" action="javascript:void(0);" method="post" name="reset_pwd" id="reset_pwd">       
                <div id="show_err"><?php if ($this->_tpl_vars['sm']['fail_msg']):  echo $this->_tpl_vars['sm']['fail_msg'];  endif; ?></div>
                <table>
                    <tr class="t1">
                        <td align="right"><b>Old password: </b></td>
                        <td>
                            <input type="password" id="opass" name="opass" class="text"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>New password: </b></td>
                        <td>
                             <input type="password" id="npass" name="npass" class="text"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>Confirm password: </b></td>
                            <td><input type="password" id="cpass" name="cpass" class="text"/></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td>
                            <input class="login_btn" type="button" value="Update" onclick="return validateResetPwd();"/>
                            <input class="login_btn" type="button" value="Reset" onclick="resetForm();"/>
                        </td>
                    </tr>
                </table>    
            </form>
    </div>
	<div class="btm"></div>
</div>
<?php echo '
<script type="text/javascript">
	function validateResetPwd() {
		var validator_reset_pwd=$("#reset_pwd").validate({ 
		rules: {
				opass:{
					required:true,
					minlength:6
				 },
				npass:{
					required:true,
					minlength:6
				 },
				cpass:{
					required:true,
					minlength:6,
					equalTo:\'#npass\'
				 }
		 },
		messages: {
				opass:{
					required:flexymsg.required,
					minlength:flexymsg.minlength
				 },
				npass:{
					required:flexymsg.required,
					minlength:flexymsg.minlength
				 },
				cpass:{
					required:flexymsg.required,
					minlength:flexymsg.minlength,
					equalTo:flexymsg.equalTo
				 }
			 }
		 });
		var x=validator_reset_pwd.form();
		if(x) {
			cShowActivity(\'1\');
			document.reset_pwd.action="http://localhost/simplehrm/index.php/employee/updatePwd";
			document.reset_pwd.submit();
		 }else{
			return false;
		 }
	 }
	function resetForm(){
		$(\'#reset_pwd\').find(\'input[type="password"]\').val(\'\');
	 }
</script>
<style type="text/css">
	#reset_pwd .text {
		width:250px;
		margin-right:10px;
		padding:3px;
		border:1px solid #ccc;
		letter-spacing:1px;
	 }
</style>
'; ?>


<!-- Template: employee/resetPwd.tpl.html End --> 