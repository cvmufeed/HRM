<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:53
         compiled from leave/leaveType.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'leave/leaveType.tpl.html', 21, false),array('modifier', 'escape', 'leave/leaveType.tpl.html', 40, false),array('function', 'cycle', 'leave/leaveType.tpl.html', 37, false),)), $this); ?>
<?php if (defined ( @LINK_SEPARATOR )): ?>
	<?php $this->assign('sep', @LINK_SEPARATOR); ?>
<?php else: ?>
	<?php $this->assign('sep', "-"); ?>
<?php endif; ?>
<div id="leave_leave_type" align="center">
    <div class="sml_box">
        <div class="top"></div>
        <div class="mdl" style="margin-left:1px;">
            <div class="cont_hdr1 fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl1 fltlft" align="left">Leave types (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)</div>
                <div class="cont_hdr_rht fltlft"></div>
            </div>
            <div class="clear"></div>	
            <div class="txtbg_top_sml"></div>
            <div class="txtbg_mdl_sml">
				<form method="post" action="http://localhost/simplehrm/index.php/leave/addLeaveTypes/ce-0" id="leave_typ"  name="leave_typ" onsubmit="return validate_leavetype();">
                <input type="hidden" name="qstart" id="qstart" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" />
                <input type="hidden" name="cnt" id="cnt" value="<?php echo count($this->_tpl_vars['sm']['list']); ?>
" />
                Leave type: <input type="text" id="leave_type" name="leave_type" size="30"><input type="submit" value="Add" id="sub" class="login_btn_sml"><input type="button" id="canclLtype" value="Cancel" style="display:none" onclick="cancel();" class="login_btn_sml"><label class="error" generated="true" for="leave_type"></label><br>
                <input type="hidden" id="temp_id" name="temp_id">
                <?php if ($this->_tpl_vars['sm']['list']): ?>			
                <table class="tbl_listing">
                    <thead>
                        <tr>
                            <th>Leave type</th>
                            <th>Number of employees</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php unset($this->_sections['cur']);
$this->_sections['cur']['name'] = 'cur';
$this->_sections['cur']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                        <?php $this->assign('x', $this->_tpl_vars['sm']['list'][$this->_sections['cur']['index']]); ?>
                            <tr class="<?php echo smarty_function_cycle(array('values' => "even,odd"), $this);?>
">
                                <td class="tl" width="39%"><?php echo $this->_tpl_vars['x']['leave_type']; ?>
</td>
                                <td class="tl" width="30%"><?php if ($this->_tpl_vars['sm']['emp'][$this->_tpl_vars['x']['id_leave_type']]):  echo $this->_tpl_vars['sm']['emp'][$this->_tpl_vars['x']['id_leave_type']];  else: ?>0<?php endif; ?></td>
                                <td class="tl" width="14%"><a href="javascript:void(0);" onclick="editleave('<?php echo $this->_tpl_vars['x']['id_leave_type']; ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['leave_type'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
');"><img src="http://localhost/simplehrm/templates/images/blue/edit_img.png" alt="edit" title="Edit"/></a></td>
                                <td class="tl"><?php if (! $this->_tpl_vars['sm']['emp'][$this->_tpl_vars['x']['id_leave_type']]): ?><a href="javascript:void(0);" onclick="return delleave('<?php echo $this->_tpl_vars['x']['id_leave_type']; ?>
','');"><img src="http://localhost/simplehrm/templates/images/blue/delete_img.png" alt="delete" title="Delete"/></a><?php endif; ?></td>
                            </tr>
                        <?php endfor; endif; ?>
                    </tbody>
                </table>
                <?php if ($this->_tpl_vars['sm']['type'] == 'advance'): ?>
                <div class="pagination_adv">
                        <?php echo $this->_tpl_vars['sm']['next_prev']->generateadv(); ?>

                    </div>
                <?php elseif ($this->_tpl_vars['sm']['type'] == 'box'): ?>
                    <div class="pagination_box">
                        <div align="center"><?php echo $this->_tpl_vars['sm']['next_prev']->generate(); ?>
</div>
                    </div>
                <?php elseif ($this->_tpl_vars['sm']['type'] == 'normal'): ?>
                    <div class="pagination">
                        <div align="center"><?php echo $this->_tpl_vars['sm']['next_prev']->generate(); ?>
</div>
                    </div>
                <?php elseif ($this->_tpl_vars['sm']['type'] == 'nextprev'): ?>
                    <div class="pagination">
                        <div align="center"><?php echo $this->_tpl_vars['sm']['next_prev']->onlynextprev(); ?>
</div>
                    </div>
                <?php elseif ($this->_tpl_vars['sm']['type'] == 'extra'): ?>
                    <div class="pagination_box">
                        <div align="center"><?php echo $this->_tpl_vars['sm']['next_prev']->generateextra(); ?>
</div>
                    </div>
                <?php else: ?>
                    <?php if ($this->_tpl_vars['sm']['type'] != 'no'): ?>
                        <div>
                            <div align="center"><?php echo $this->_tpl_vars['sm']['next_prev']->generate(); ?>
</div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php else: ?>
                No records found.
                    <?php endif; ?>
		</form>
        	</div>
            <div class="txtbg_btm_sml"></div>
        </div>
        <div class="btm"></div>
    </div>
    <br><div align=center>Note: If a leave type cannot be deleted, then this type is permanent in the database.</div>
</div>



<?php echo '
<script type="text/javascript">
$("#leave_type_name").autocomplete(\'http://localhost/simplehrm/index.php/leave/autoLeaveTypeName/ce-0-for-norauto\', {autoPrefill: false });
$("#leave_type_name").result(function(event, data, formatted) {
	if(data) {
		$(\'#leave_type_name\').val(data[1]);
 	 }
 });	
function validate_leavetype() {
	var validator=$("#leave_typ").validate({
			rules: {
				"leave_type": {
					required:true
				 }
			 },
			messages: {
				"leave_type":{
					required:flexymsg.required
				 }
			 }
		 });
		var x=validator.form();
		if(x)
			cShowActivity(\'1\');
		return x;
 }
function editleave(id,val){
	$("#temp_id").val(id);
	$(".error").html(\'\');
	$("#leave_type").val(val);
	$(\'#canclLtype\').show();
	$("#sub").val(\'Update\');
	$("#leave_typ").attr("action","http://localhost/simplehrm/index.php/leave/updateLeavetype/ce-0");
 }
function delleave(id,chc){
	 var url="http://localhost/simplehrm/index.php/leave/deleteLeave";
	 var qstart=$("#qstart").val();
	 var cnt=$("#cnt").val();
	 if(chc==\'\'){
		chc=jqueryConfirm("Do you really want to delete this record?","delleave",id);
	  }
	 if(chc){
		cShowActivity(\'1\');
		 $.post(url,{ce:0,id:id,chk:1,cnt:cnt,qstart:qstart },function(res){
			$(\'#leave_leave_type\').html(res);
			cHideActivity();
		  });
	  }else
	 	return false;
 }
function cancel(){
	$("#leave_type").val(\'\');
	$(".error").html(\'\');
	$(\'#canclLtype\').hide();
	$("#sub").val(\'Add\');
	$("#leave_typ").attr("action","http://localhost/simplehrm/index.php/leave/addLeaveTypes/ce-0");
 }
</script>
'; ?>
