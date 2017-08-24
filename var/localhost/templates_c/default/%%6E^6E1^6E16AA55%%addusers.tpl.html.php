<?php /* Smarty version 2.6.7, created on 2017-08-24 10:52:26
         compiled from setting/addusers.tpl.html */ ?>

<!-- Template: setting/addusers.tpl.html Start 24/08/2017 10:52:26 --> 
 <div style="width:405px;height:300px" id="setting_userslist">
    <div class="modal_heading">
        <div class="lft fltlft"></div>
        <div class="mdl fltlft" style="width:333px;">
         <?php if ($this->_tpl_vars['sm']['users_edit']): ?> Edit <?php else: ?> Add <?php endif; ?> Users  </div>
        <div class="rht fltlft"></div>
        <div class="clear"></div>
    </div>
    <div class="modal_body">

    <span id="users_msg" class="error"></span><br>
    <form id="add_users" name="add_users" method="post" action="javascript:void(0);">
        <table class="listing_tbl">
        <?php if ($this->_tpl_vars['sm']['users_edit']['id_userdetails']): ?>
		    		<input type="hidden" id="users[temp_id]" name="users[temp_id]" value="<?php echo $this->_tpl_vars['sm']['users_edit']['id_userdetails']; ?>
">
		    	<?php endif; ?>
		<tr>
            <td align='right'><b>Display Name: </b></td>
            <td><input type="text" name="users[display_name]" value="<?php echo $this->_tpl_vars['sm']['users_edit']['displayname']; ?>
" class="text"></td>
        </tr>
          <tr>
            <td align='right'><b>User Name: </b></td>
            <td><input type="text" name="users[user_name]" value="<?php echo $this->_tpl_vars['sm']['users_edit']['email_id']; ?>
" class="text"></td>
        </tr>
        <tr>
            <td align='right'><b>Password: </b></td>
            <td><input type="password" name="users[user_pwd]" value="" class="password"></td>
        </tr>
        <tr>
        <td align='right'><b>Role Name : </b></td>
        <td>
          <select  name="users[user_role]" id="users[user_role]">
        <option value="">-- Select --</option>
    <?php unset($this->_sections['cur']);
$this->_sections['cur']['name'] = 'cur';
$this->_sections['cur']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['roles']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cur']['show'] = true;
$this->_sections['cur']['max'] = $this->_sections['cur']['loop'];
$this->_sections['cur']['step'] = 1;
$this->_sections['cur']['start'] = $this->_sections['cur']['step'] > 0 ? 0 : $this->_sections['cur']['loop']-1;
if ($this->_sections['cur']['show']) {
    $this->_sections['cur']['total'] = $this->_sections['cur']['loop'];
    if ($this->_sections['cur']['total'] == 0)
        $this->_sections['cur']['show'] = false;
} else
    $this->_sections['cur']['total'] = 0;
if ($this->_sections['cur']['show']):

            for ($this->_sections['cur']['index'] = $this->_sections['cur']['start'], $this->_sections['cur']['iteration'] = 1;
                 $this->_sections['cur']['iteration'] <= $this->_sections['cur']['total'];
                 $this->_sections['cur']['index'] += $this->_sections['cur']['step'], $this->_sections['cur']['iteration']++):
$this->_sections['cur']['rownum'] = $this->_sections['cur']['iteration'];
$this->_sections['cur']['index_prev'] = $this->_sections['cur']['index'] - $this->_sections['cur']['step'];
$this->_sections['cur']['index_next'] = $this->_sections['cur']['index'] + $this->_sections['cur']['step'];
$this->_sections['cur']['first']      = ($this->_sections['cur']['iteration'] == 1);
$this->_sections['cur']['last']       = ($this->_sections['cur']['iteration'] == $this->_sections['cur']['total']);
?>
    <?php $this->assign('x', $this->_tpl_vars['sm']['roles'][$this->_sections['cur']['index']]); ?>
     <option value="<?php echo $this->_tpl_vars['x']['id_roles']; ?>
" <?php if ($this->_tpl_vars['sm']['users_edit']['role'] == $this->_tpl_vars['x']['id_roles']): ?> selected <?php endif; ?> > <?php echo $this->_tpl_vars['x']['role_name']; ?>
</option>
         <?php endfor; endif; ?>
          </select>
            </td>
            </tr>
          <tr>

            <td align='right'><b>Is Active: </b></td>
            <?php if ($this->_tpl_vars['sm']['users_edit']['isactive']): ?>
            <td><input type="checkbox"  name="users[isactive]" value="1" checked="checked"></td>
              <?php else: ?>
            <td><input type="checkbox" name="users[isactive]" <?php if (checked): ?> value="1" <?php else: ?> value="0" <?php endif; ?>></td>
            <?php endif; ?>
        </tr>
         <tr>
            <td></td>
            <td>
                <input type="button" name="save_property" value="Save" onclick="save('<?php echo $this->_tpl_vars['sm']['users_edit']['id_admin']; ?>
');" class="login_btn">
            </td>
            </tr>
    </table>
    </form>

	</div>
</div>
<?php echo '
<script type="text/javascript">
forminfo("#add_users");
function save(id_users){
	$("#users_msg").html("");
	var res = addUsers();
     if(res){
		cShowActivity(\'2\');
		var data=$("#add_users").serialize();
  		if(id_users!=\'\')
		{
		var url="http://localhost/simplehrm/index.php/setting/updateusers?"+data;
	//	alert(url);
		 }
		else
		{
			var url="http://localhost/simplehrm/index.php/setting/insertusers?"+data;
		 }
  $.post(url,{ce:0 },function (res){
  			$("#setting_userslist").html(res);
				$.fancybox.close();
                cHideActivity();
		 });
	 }else
		return false;
 }
function addUsers(){
	var validator_users=$("#add_users").validate({
		rules: {
	    	"users[display_name]": {
				required:true
			 },
			"users[user_name]": {
				required:true,
                email:true
			 },
			"users[user_pwd]": {
				required:true

			 },
			"users[user_role]": {
				required:true

			 }

		 },
		messages: {
	    	"users[display_name]":{
			required:flexymsg.required,
			 },
			"users[user_name]":{
			required:flexymsg.required,
			email:\'Please enter a valid email address.\'
			 },
            "users[user_pwd]": {
				required:flexymsg.required,
             },
            "users[user_role]": {
    required:flexymsg.required,

			 }
		 }
	 });
	return validator_users.form();
 }
</script>
<style type="text/css">
#add_users .text {
	width:200px;
	margin-right:10px;
	padding:3px;
	border:1px solid #ccc;
	letter-spacing:1px;
 }
#add_users select {
	border:1px solid #ccc;
	width:209px;
	padding:4px;
 }
#add_users .password {
	border:1px solid #ccc;
	width:199px;
 padding:4px;
 }
</style>
'; ?>













<!-- Template: setting/addusers.tpl.html End --> 