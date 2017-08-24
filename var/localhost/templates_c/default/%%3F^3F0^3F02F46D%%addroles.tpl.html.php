<?php /* Smarty version 2.6.7, created on 2017-08-24 10:52:58
         compiled from setting/addroles.tpl.html */ ?>

<!-- Template: setting/addroles.tpl.html Start 24/08/2017 10:52:58 --> 
 <div style="width:405px;" id="setting_roleslist">
    <div class="modal_heading">
        <div class="lft fltlft"></div>
        <div class="mdl fltlft" style="width:333px;">
         <?php if ($this->_tpl_vars['sm']['roles_edit']): ?> Edit <?php else: ?> Add <?php endif; ?> Roles  </div>
        <div class="rht fltlft"></div>
        <div class="clear"></div>
    </div>
    <div class="modal_body">

    <span id="roles_msg" class="error"></span><br>
    <form id="add_roles" name="add_roles" method="post" action="javascript:void(0);">
        <table class="listing_tbl">
        <?php if ($this->_tpl_vars['sm']['roles_edit']['id_roles']): ?>
		    		<input type="hidden" id="roles[temp_id]" name="roles[temp_id]" value="<?php echo $this->_tpl_vars['sm']['roles_edit']['id_roles']; ?>
">
		    	<?php endif; ?>

            <td align='right'><b>Role Name: </b></td>
            <td><input type="text" name="roles[role_name]" value="<?php echo $this->_tpl_vars['sm']['roles_edit']['role_name']; ?>
"class="text"></td>
        </tr>
        <tr>
            <td align='right'><b>Role Description : </b></td>
            <td><input type="text" name="roles[role_description]" value="<?php echo $this->_tpl_vars['sm']['roles_edit']['role_description']; ?>
" class="text"></td>
        </tr>
         <tr>
            <td></td>
            <td>
                <input type="button" name="save_property" value="Save" onclick="save('<?php echo $this->_tpl_vars['sm']['roles_edit']['id_roles']; ?>
');" class="login_btn">
            </td>
        </tr>
    </table>
    </form>

	</div>
</div>
<?php echo '
<script type="text/javascript">
forminfo("#add_roles");
function save(id_roles){
	$("#roles_msg").html("");
	var res = addRoles();
     if(res){
		cShowActivity(\'2\');
		var data=$("#add_roles").serialize();
  		if(id_roles!=\'\')
		{
		var url="http://localhost/simplehrm/index.php/setting/updateroles?"+data;
		 }
		else
		{
			var url="http://localhost/simplehrm/index.php/setting/insertroles?"+data;
		 }
  $.post(url,{ce:0 },function (res){
  			$("#setting_rolelist").html(res);
				$.fancybox.close();
                cHideActivity();
		 });
	 }else
		return false;
 }
function addRoles(){
	var validator_role=$("#add_roles").validate({
		rules: {
			"roles[role_name]": {
				required:true
			 },

		 },
		messages: {
			"roles[role_name]":{
				required:flexymsg.required
			 },

		 }
	 });
	return validator_role.form();
 }
</script>
<style type="text/css">
#add_roles .text {
	width:200px;
	margin-right:10px;
	padding:3px;
	border:1px solid #ccc;
	letter-spacing:1px;
 }
#add_roles select {
	border:1px solid #ccc;
	width:209px;
	padding:4px;
 }
</style>
'; ?>













<!-- Template: setting/addroles.tpl.html End --> 