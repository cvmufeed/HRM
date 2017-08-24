<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:55
         compiled from leave/leaveRequestList.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'leave/leaveRequestList.tpl.html', 69, false),array('function', 'html_options', 'leave/leaveRequestList.tpl.html', 95, false),array('modifier', 'capitalize', 'leave/leaveRequestList.tpl.html', 87, false),array('modifier', 'date_format', 'leave/leaveRequestList.tpl.html', 88, false),)), $this); ?>

<!-- Template: leave/leaveRequestList.tpl.html Start 24/08/2017 10:50:55 --> 
 <input type="hidden" name="qstart" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" id="qstart">
<input type="hidden" name="rshow" value="<?php echo $this->_tpl_vars['sm']['show']; ?>
" id="rshow">
<input type="hidden" name="rtot" value="<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
" id="rtot">
<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
        <div class="cont_hdr1 fltlft">
		<?php if ($_SESSION['id_company']): ?>
        
			<div class="cont_txt">
			<div class="txtbg_top fltlft"></div>
				<div class="txtbg_mdl fltlft">
		
				<div align="center" style="margin-bottom:5px;">
						Filter By : 
						<?php if (count($_from = (array)$this->_tpl_vars['sm']['status'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
							<?php $this->assign('l', $this->_tpl_vars['sm']['leavestatus'][$this->_tpl_vars['key']]); ?>
							<input type="checkbox" name="leave_status[]" id="leave_type<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['key']; ?>
" onclick="searchLeaveRequest('','','','0');" class="leavestatus" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['l']): ?>checked="checked"<?php endif; ?>>&nbsp;<?php echo $this->_tpl_vars['item']; ?>

			 			<?php endforeach; endif; unset($_from); ?>
				</div>
			</div>
				<div class="txtbg_btm fltlft"></div>
			<div class="clear"></div>
			</div>
  		<?php endif; ?>
        	<div class="cont_hdr1" style="padding-left:10px;">
            <div class="cont_hdr_lft fltlft"></div>		
            <div class="cont_hdr_mdl1 fltlft" style="width:881px;">Leave requests (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)
            	<div class="fltrht">
                      <?php if ($_SESSION['id_employee']): ?><input type="button" name="addLeaveReq" value="Apply" onclick="addLeave();"/><?php endif; ?>
                      <?php if ($this->_tpl_vars['sm']['list']): ?><input type="button" name="deleteLeave" value="Delete" onclick="deleteAll('chkbox_leave','');"/><?php endif; ?>
                </div>                
            </div>
			<div class="cont_hdr_rht fltlft"></div>
	        <div class="clrbth"></div>
            </div>
        </div>
        <div class="clrbth"></div>
        <div class="cont_txt">
        <div class="txtbg_top fltlft"></div>
		<div class="txtbg_mdl fltlft">
        <?php if ($this->_tpl_vars['sm']['list']): ?>
        	<table id="tbl" class="tbl_listing">
		<thead>
			<tr>
				<th>
					<?php if ($this->_tpl_vars['sm']['list']): ?>
					<input type="checkbox" name="chk_all" id="chk_all" onclick="checkUncheck('chkbox_leave');" title="Check to select all records">
					<?php endif; ?>
				</th>
				<?php if ($_SESSION['id_company']): ?>
				<th>Profile Pic</th>
				<?php endif; ?>
				<th align="left">Employee</th>
				<th align="left">Type</th>
				<th align="left">From</th>
				<th align="left">To</th>
				<th align="left">Working days</th>
				<th align="left">Note</th>
				<th align="left" width="97">Status</th>
				<th>Action</th>
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
		    	<td>
		    		<?php if ($this->_tpl_vars['x']['leave_status'] == 1 || $_SESSION['id_company']): ?>
		    		<input type="checkbox" name="chk_box" id="chk<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
" value="<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
" class="chkbox_leave">
		    		<?php else: ?>
		    		<input type="checkbox" name="chk_box" id="chk<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
" value="<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
" disabled>
		    		<?php endif; ?>
		    	</td>
		    	<?php if ($_SESSION['id_company']): ?>
			<td onclick="empDetail('<?php echo $this->_tpl_vars['x']['id_employee']; ?>
');" style="cursor:pointer;">
	    			<?php if ($this->_tpl_vars['sm']['employee'][$this->_tpl_vars['x']['id_employee']]['avatar'] == ''): ?>
	    				<img src="http://localhost/simplehrm/templates/css_theme/img/avatar/search/hrm_<?php if ($this->_tpl_vars['sm']['employee'][$this->_tpl_vars['x']['id_employee']]['gender'] == M): ?>male.jpg<?php else: ?>female.jpg<?php endif; ?>" title="Profile Pic">&emsp;
	    			<?php else: ?>
	    				<img src="http://localhost/simplehrm/image/thumb4_search/avatar/<?php echo $this->_tpl_vars['x']['id_employee']; ?>
_<?php echo $this->_tpl_vars['sm']['employee'][$this->_tpl_vars['x']['id_employee']]['avatar']; ?>
" title="Profile Pic">
	    			<?php endif; ?>
			</td>
			<?php endif; ?>
			<td><?php echo $this->_tpl_vars['sm']['employee'][$this->_tpl_vars['x']['id_employee']]['name']; ?>
</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['sm']['leave_type_res'][$this->_tpl_vars['x']['leave_type']])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['from_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['to_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
</td>
			<td align="center"><?php echo $this->_tpl_vars['x']['work_days']; ?>
</td>
			<td><?php echo $this->_tpl_vars['x']['notes']; ?>
</td>
			<td>
				<?php if ($_SESSION['id_company'] && $this->_tpl_vars['x']['leave_status'] == 1): ?>
					<select id="cur_leave_status<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
" name="change[leave_type]" onchange="changeLeaveType('<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
');">
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['status'],'selected' => $this->_tpl_vars['x']['leave_status']), $this);?>

					</select>
				<?php else: ?>
					<?php echo $this->_tpl_vars['sm']['status'][$this->_tpl_vars['x']['leave_status']]; ?>
	
				<?php endif; ?>
			</td>
			<td>
				<?php if (( $this->_tpl_vars['x']['leave_status'] == 1 || $_SESSION['id_company'] )): ?> 
                    <img src="http://localhost/simplehrm/templates/images/blue/edit_img.png" alt="edit" title="Edit" onclick="editLeave('<?php echo $this->_tpl_vars['x']['id_leave_req']; ?>
');" style="cursor:pointer;">
                <?php else: ?>
                    NA
                <?php endif; ?>
            </td>
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
         	<br><div align="center">No leave request found.</div><br>
    	<?php endif; ?>
        </div>
		<div class="txtbg_btm fltlft"></div>
        <div class="clear"></div>
        </div>
    </div>
    <div class="cont_bg_btm"></div>
</div>
<?php echo '
<script type="text/javascript">
	var msg = \'';  echo $_SESSION['amsg'];  echo '\';
	callmsg(msg);
	function deleteAll(cls,chc) {
		var keys=\'\';
		var i=0;
		$(\'.\'+cls).each(function(){
			if($(this).is(\':checked\')){
				keys +=","+$(this).val();
				i++;
			 }
		 });
		keys=keys.substr(1);
		var rshoid=\'rshow\';
		var rshow = parseInt($("#"+rshoid).val());
		var rtot = parseInt($("#rtot").val()) - i;
		var qstrt = parseInt($.trim($("#qstart").val()));
		var qs = (rtot%rshow)!=0 || (qstrt!=rtot) || (qstrt==0 && rtot==0) ? \'\' : Math.floor((rtot-1)/rshow)*rshow;
		if(!keys){
			jqueryAlert("Select atleast one checkbox.");
			return false;
		 }else{
			if(chc==\'\'){
				chc=jqueryConfirm("Are you sure want to delete leave request(s) ?","deleteAll",cls);
			 }
			if(chc){
				searchLeaveRequest(\'for_del\',\'\',keys,qs);
			 }
		 }
	 }
	function addLeave(){
		cShowActivity(\'\');
		var url = "http://localhost/simplehrm/index.php/";
		$.post(url,{page:"leave",choice:"addLeave",ce:0 },function(res){
			show_fancybox(res);
		 });
	 }
	function checkUncheck(cls){
		if(document.getElementById("chk_all").checked==true){
			$(\'.\'+cls).each(function(){	$(this).attr(\'checked\',\'checked\');   });
		 }else{
			$(\'.\'+cls).each(function(){	$(this).removeAttr(\'checked\');	  });
		 }
	 }
	function editLeave(id_leave){
		cShowActivity(\'\');
		var url = "http://localhost/simplehrm/index.php/";
		$.post(url,{page:"leave",choice:"editLeave",ce:0,id_leave:id_leave },function(res){
			show_fancybox(res);
		 });
	 }
	function changeLeaveType(id_leave){
		var status=$.trim($("#cur_leave_status"+id_leave).val());
		var leavestatus=\'\';
		$(\'.leavestatus\').each(function(){
			if($(this).is(\':checked\'))
			leavestatus+=","+$(this).val();
		 });
		var i=1;
		var rshoid=\'rshow\';
		var rshow = parseInt($("#"+rshoid).val());
		var rtot = parseInt($("#rtot").val()) - i;
		var qstrt = parseInt($.trim($("#qstart").val()));
		var qs = (rtot%rshow)!=0 || (qstrt!=rtot) || (qstrt==0 && rtot==0) ? \'\' : Math.floor((rtot-1)/rshow)*rshow;
		if(qs===\'\'){
			qs=$.trim($("#qstart").val());
		 }
		var url = "http://localhost/simplehrm/index.php/";
		cShowActivity(\'1\');
		$.post(url,{page:"leave",choice:"updateLeaveStatus",ce:0,id_leave:id_leave,status:status,qs:qs,chk:1,leavestatus:leavestatus },function(res){
			$("#leave_leaveRequest").html(res);
			cHideActivity();
		 });
	 }
</script>
'; ?>


<!-- Template: leave/leaveRequestList.tpl.html End --> 