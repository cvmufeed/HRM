<?php /* Smarty version 2.6.7, created on 2017-08-24 10:49:08
         compiled from adminstration/addReminder.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'adminstration/addReminder.tpl.html', 96, false),)), $this); ?>

<!-- Template: adminstration/addReminder.tpl.html Start 24/08/2017 10:49:08 --> 
 <script type="text/javascript" src="http://localhost/simplehrm/libsext/jquery/jquery-ui-timepicker-addon.js"></script>
<!--<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/jquery-ui-1.8.6.custom.css"/>-->
<?php echo '
<script type="text/javascript">
	forminfo("#freminder");
	$("#forremind").val(\'1\');
	$(document).ready(function(){
		$(\'#reminder_date\').datepicker({
			dateFormat:\'dd-mm-yy\'
		 });
		$(\'#reminder_time\').timepicker({
			timeFormat: \'hh:mm TT\',
			ampm: true
		 });
	 });
	function validate_reminder(){
		var validator=$("#freminder").validate({
			rules: {
					"reminder[reminder]": {
						required:true
					 },
					"reminder[reminder_date]": {
						required:true
					 },
					"reminder_time": {
						required:true
					 }			
				 },
				messages: {
					"reminder[reminder]":{
						required:flexymsg.required
					 },
					"reminder[reminder_date]": {
						required:flexymsg.required
					 },
					"reminder_time": {
						required:flexymsg.required
					 }
				 }
		 });
		var x = validator.form();
		if(x)
		     cShowActivity(\'2\');
		return x;
	 }
	function cancel(){
		$(".error").html(\'\');
		window.location.href="http://localhost/simplehrm/index.php/adminstration/reminders";
	 }
</script>
<style>
.ui-timepicker-div .ui-widget-header{ margin-bottom: 8px;  }
.ui-timepicker-div dl{ text-align: left;  }
.ui-timepicker-div dl dt{ height: 25px;  }
.ui-timepicker-div dl dd{ margin: -25px 0 10px 65px;  }
.ui-timepicker-div td { font-size: 90%;  }
</style>
'; ?>

<div style="width:460px;">
    <div class="modal_heading">
        <div class="lft fltlft"></div>
        <div class="mdl fltlft" style="width:388px;">
            <?php if ($this->_tpl_vars['sm']['reminder']): ?>Update<?php else: ?>Add New<?php endif; ?> Reminder
        </div>
        <div class="rht fltlft"></div>
        <div class="clear"></div>
    </div>
    <div class="modal_body">
	<input type="hidden" id="forremind">
        <form method="post" action="http://localhost/simplehrm/index.php/adminstration/insertUpdateReminder/" id="freminder"  name="freminder" onsubmit="javascript:return validate_reminder();">
        <input type="hidden" id="temp_id" name="temp_id" value="<?php echo $this->_tpl_vars['sm']['id']; ?>
">
        <input type="hidden" id="tempid" name="tempid" value="<?php echo $this->_tpl_vars['sm']['reminder']['id_reminder']; ?>
">
        <input type="hidden" name="qstart" id="qstart" value="<?php echo $this->_tpl_vars['sm']['qstart']; ?>
" />		
        <table class="listing_tbl">
            <tr>
                <td valign="top" align="right"><b>Please remind me to:</b> </td>
                <td><textarea name="reminder[reminder]" id="reminder" rows="3" cols="30"><?php echo $this->_tpl_vars['sm']['reminder']['reminder']; ?>
</textarea></td>
            </tr>
            <tr>
                <td align="right"><b>Date:</b></td>
                <td>
                    <input type="text" name="reminder[reminder_date]" id="reminder_date" size = '8' value="<?php echo $this->_tpl_vars['sm']['reminder']['reminder_date']; ?>
"></td>
                    </tr>
            <tr>
            <td align="right"><b>Time:</b></td>
            <td>
                    <input type="text" name="reminder_time" id="reminder_time" size = '6' value="<?php echo $this->_tpl_vars['sm']['reminder']['reminder_time']; ?>
">
                </td>			
            </tr>
            <tr>
                <td align="right"><b>Recurring:</b> </td>
                <td>
                    <select name="reminder[recurrence_status]" id="recurrence_status">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['duration'],'selected' => $this->_tpl_vars['sm']['reminder']['recurrence_status']), $this);?>

                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="<?php if ($this->_tpl_vars['sm']['reminder']): ?>Update<?php else: ?>Save<?php endif; ?>" id="sb" class="login_btn"><input type="button" id="canclRem" value="Cancel" style="display:none" onclick="cancel();" class="login_btn"></td>
            </tr>
        </table>
    </form>
    </div>
</div>

<!-- Template: adminstration/addReminder.tpl.html End --> 