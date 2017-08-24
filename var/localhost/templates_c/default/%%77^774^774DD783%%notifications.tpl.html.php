<?php /* Smarty version 2.6.7, created on 2017-08-24 10:54:46
         compiled from adminstration/notifications.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'adminstration/notifications.tpl.html', 31, false),)), $this); ?>

<!-- Template: adminstration/notifications.tpl.html Start 24/08/2017 10:54:46 --> 
 <div id="adminstration_leave_type">
    <div class="cont">
        <div class="cont_bg_top"></div>
        <div class="cont_bg_mdl">
            <form method="post" action="http://localhost/simplehrm/index.php/adminstration/<?php if ($this->_tpl_vars['sm']['res']): ?>updateNotification<?php else: ?>insertNotification<?php endif; ?>" id="notifi"  name="notifi" onsubmit="return validate_notifi();">
                <input type="hidden" id="qstart" <?php if ($this->_tpl_vars['sm']['qstart']): ?> value="<?php echo $this->_tpl_vars['sm']['qstart']; ?>
"<?php else: ?> value="1"<?php endif; ?>/>
                <input type="hidden" id="notify_id" name="notify_id" value="<?php echo $this->_tpl_vars['sm']['res']['id_notification']; ?>
">	
                <div class="fltlft">
                    <div class="cont_hdr fltlft" style="margin-top:-10px">
                        <div class="cont_hdr_lft fltlft"></div>
                        <div class="cont_hdr_mdl fltlft">Automatic notifications</div>
                        <div class="cont_hdr_rht fltlft"></div>
                        <div class="clear"></div>
                        <div id="dv1">
                            <table cellspacing="0" border="0" width="80%" align="left">
<tr><td colspan="2">Send notifications near following dates:<p></td></tr>
                                <tr>
                                    <td width=10% align="center" valign="middle"><input type="checkbox" name="notification[birthday]" id="birthday" <?php if ($this->_tpl_vars['sm']['res']['birthday']): ?>checked="checked" value="1" <?php else: ?>value="0" <?php endif; ?>></td>
                                    <td valign="center">Employee birthdays</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="middle"><input type="checkbox" name="notification[contract_end]" id="contract_end" <?php if ($this->_tpl_vars['sm']['res']['contract_end']): ?>checked="checked" value="1" <?php else: ?>value="0"<?php endif; ?>></td>
                                    <td valign="center">Employee contract ending</td>
                                </tr>
                                <tr>
                                    <td colspaln="2"><div style="margin:6px 0px 0px 4px;">Duration: &nbsp; </div></td>
                                    <td>
                                        <select name="notification[notification_status]" id="notification_status" style="width:150px;">
                                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['duration'],'selected' => $this->_tpl_vars['sm']['res']['notification_status']), $this);?>

                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>             
                    </div>
                    <div class="cont_hdr fltlft" style="margin-top:-10px">
                        <div class="cont_hdr_lft fltlft"></div>
                        <div class="cont_hdr_mdl fltlft">Event notifications</div>
                        <div class="cont_hdr_rht fltlft"></div>
                        <div class="clear"></div>
                        <div id="dv2">
                            <table cellspacing="0" width="80%" align="left">
                                <tr>
<tr><td colspan="2">Send e-mail notification when following events occur:<p></td></tr>
                                    <td  width=10% align="center" valign="middle"><input type="checkbox" name="notification[emp_add]" id="emp_add" <?php if ($this->_tpl_vars['sm']['res']['emp_add']): ?>checked="checked" value="1" <?php else: ?>value="0"<?php endif; ?>></td>
                                    <td valign="center">An employee is added</td>
                                </tr>
                                <tr>
                                    <td align="center"><input type="checkbox" name="notification[emp_modify]" id="emp_modify" <?php if ($this->_tpl_vars['sm']['res']['emp_modify']): ?>checked="checked" value="1" <?php else: ?>value="0"<?php endif; ?> ></td>
                                    <td valign="center">An employee is modified</td>
                                </tr>
                                <tr>
                                    <td align="center"><input type="checkbox" name="notification[emp_remove]" id="emp_remove" <?php if ($this->_tpl_vars['sm']['res']['emp_remove']): ?>checked="checked" value="1" <?php else: ?>value="0"<?php endif; ?> ></td>
                                    <td valign="center">An employee is removed</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clrbth"></div>
                <div align="left" style="width:66%; margin-left:50px;">
                    <input type="checkbox" id="chk1" onclick="return show_txt();" value="1" <?php if ($this->_tpl_vars['sm']['res']['id_employee'] != 0): ?>checked="checked"<?php endif; ?>><font color="#707070">Send a copy of all event notifications to this user:</font><input type="text" size="35" id="employee_name" name="employee_name" value="<?php if ($this->_tpl_vars['sm']['res']['id_employee'] != 0):  echo $this->_tpl_vars['sm']['name'];  endif; ?>" style="margin-left:10px;"><input type="hidden" id="id_employee" name="notification[id_employee]" value="<?php echo $this->_tpl_vars['sm']['res']['id_employee']; ?>
"><br /><div style="margin-right:160px; margin-top:6px;" class="fltrht"><input type="submit" value="Save" id="sub" class="login_btn"></div>
                <div class="clrbth"></div>    
                </div>
            </form>
        </div>
        <div class="cont_bg_btm"></div>
    </div>
</div>
<?php echo '
<script type="text/javascript">
function validate_notifi() {
	var x=true;
	if($("#chk1").attr("checked")){
		if(!$("#employee_name").val()){
			x=false;
			$("#target").html(\'\');
			jqueryAlert("Please enter the user field");
		 }
	 }
	if(x)
		 cShowActivity(\'1\');
	return x;
 }
function show_txt(){
	var emp_name=\'';  echo $this->_tpl_vars['sm']['name'];  echo '\';
	var id_emp=\'';  echo $this->_tpl_vars['sm']['res']['id_employee'];  echo '\';
	
	if($("#chk1").attr("checked")){
		$("#employee_name").focus();
		$("#employee_name").val(emp_name);
		$("#id_employee").val(id_emp);
	 }else{		
		$("#employee_name").val(\'\');
		$("#id_employee").val(\'\');
	 }
 }
$(document).ready(function(){
	$("#employee_name").autocomplete("http://localhost/simplehrm/index.php/adminstration/userAutoComplete/ce-0-for-auto");
	$("#employee_name").result(function(event, data, formatted) {
	 if (data) {
		var empId = data[1].split("::");
		$(\'#employee_name\').val(empId[1]);
		$(\'#id_employee\').val(empId[0]);
		if(empId[0]==\'abc\'){
			window.location="http://localhost/simplehrm/";
		 }
	 }
	 });
 });
</script>
'; ?>


<!-- Template: adminstration/notifications.tpl.html End --> 