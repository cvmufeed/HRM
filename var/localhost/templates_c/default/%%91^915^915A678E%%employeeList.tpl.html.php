<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:23
         compiled from employee/employeeList.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'employee/employeeList.tpl.html', 33, false),array('modifier', 'capitalize', 'employee/employeeList.tpl.html', 95, false),array('modifier', 'default', 'employee/employeeList.tpl.html', 95, false),array('modifier', 'date_format', 'employee/employeeList.tpl.html', 96, false),array('function', 'cycle', 'employee/employeeList.tpl.html', 85, false),)), $this); ?>

<!-- Template: employee/employeeList.tpl.html Start 24/08/2017 10:53:23 --> 
 <?php $this->assign('emp_sts', $this->_tpl_vars['util']->get_values_from_config('EMPLOYMENT_STATUS')); ?>
<?php $this->assign('m', $this->_tpl_vars['sm']['next_prev']->module); ?>
<?php if (defined ( @LINK_SEPARATOR )): ?>
	<?php $this->assign('sep', @LINK_SEPARATOR); ?>
<?php else: ?>
	<?php $this->assign('sep', "-"); ?>
<?php endif; ?>
<input type="hidden" name="qstart" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" id="qstart">
<input type="hidden" name="rshow" value="<?php echo $this->_tpl_vars['sm']['show']; ?>
" id="rshow">
<input type="hidden" name="rtot" value="<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
" id="rtot">
<div class="sml_box">
    <div class="top"></div>
    <div class="mdl">
    	<div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft">
                <div class="fltlft">
                	<?php if ($_SESSION['auto'] == 1): ?>Terminated <?php endif; ?>Employees list (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)
                </div>
                <div class="fltrht">
                  <?php if ($_SESSION['auto'] != 1): ?>
                      <input type="button" name="addEmpl" value="Add" onclick="addEmployee();" class="fltrht" />
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['sm']['list']): ?>
                     <input type="button" name="delEmpl" value="Delete" onclick="deleteAll('chkbox_emp','');" class="fltrht"/>
                 <?php endif; ?>
                </div>
                <div class="clear"></div>
            </div>
              <input type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" />
              <input type="hidden" name="cnt" id="cnt" value="<?php echo count($this->_tpl_vars['sm']['list']); ?>
" />
              <input type="hidden" name="idprnt" id="idprnt" value="<?php echo $this->_tpl_vars['sm']['idparent']; ?>
" />
            <div class="cont_hdr_rht fltlft">
            </div>
        </div>
        <div class="clrbth"></div>
        <div style="margin-left:20px">
            	<div class="txtbg_top_sml fltlft"></div>
                <div class="txtbg_mdl_sml fltlft">
                	<table class="listing_tbl">
                            <tr>
                                <td width="20%">Employee name: </td>
                                <td width="80%"><input type="text" name="employee_name" id="employee_name" autocomplete="off" value=""/><input type="button" name="search" id="search"  value="Search" onclick="searchEmployeeList('','','','0');" class="login_btn"/></td>
                            </tr>
                        </table>
                	<?php if ($this->_tpl_vars['sm']['list']): ?>
                        <table width="97%" cellpadding="0" cellspacing="0" border="0" align="center" class="tbl_listing" style="margin-bottom:25px;">
                            <tr>
                                <th class="user">
                                    <?php if ($this->_tpl_vars['sm']['list']): ?>
                                    <input type="checkbox" name="chk_all" id="chk_all" onclick="checkUncheck('chkbox_emp');" title="Check to select all employee">
                                    <?php endif; ?>
                                </th>
                                <th class="email">Picture
                                <?php $this->_foreach['foric'] = array('total' => count($_from = (array)$this->_tpl_vars['sm']['field']), 'iteration' => 0);
if ($this->_foreach['foric']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['foric']['iteration']++;
?>
                                    <?php if ($_SESSION['user_type'] == 99 || $this->_tpl_vars['item']['0'] != Id): ?>
                                            <?php if ($this->_tpl_vars['key'] == $_SESSION[$this->_tpl_vars['m']]['sort_by']): ?>
                                                <?php if ($_SESSION[$this->_tpl_vars['m']]['sort_order'] == 'ASC'): ?>
                                                    <?php $this->assign('cls', 'asc'); ?>
                                                <?php else: ?>
                                                    <?php $this->assign('cls', 'desc'); ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php $this->assign('cls', ""); ?>
                                            <?php endif; ?>
                                            <th class="email <?php echo $this->_tpl_vars['cls']; ?>
" title="Click on <?php echo $this->_tpl_vars['item']['0']; ?>
 to sort" <?php if (($this->_foreach['foric']['iteration'] == $this->_foreach['foric']['total'])): ?>style='border-right:none'<?php endif; ?>>
                                                <?php if ($this->_tpl_vars['item']['1'] != 0): ?>
                                                    <?php if ($this->_tpl_vars['sm']['ajax']): ?>
                                                        <a href="javascript:get_next_page('http://localhost/simplehrm/<?php echo $this->_tpl_vars['sm']['uri'];  echo $this->_tpl_vars['sep']; ?>
sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
',0,0,'<?php echo $_REQUEST['page']; ?>
_<?php echo $_REQUEST['choice']; ?>
')" class="tab_lable"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                                    <?php else: ?>
                                                        <a href="http://localhost/simplehrm/<?php echo $this->_tpl_vars['sm']['uri'];  echo $this->_tpl_vars['sep']; ?>
sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
"><b><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></b></a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <b><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></b>
                                                <?php endif; ?>
                                            </th>
                                    <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                                </th>
                            </tr>
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
" height="70">
                                <td><input type="checkbox" name="chk_box" id="chk<?php echo $this->_tpl_vars['x']['id_employee']; ?>
" value="<?php echo $this->_tpl_vars['x']['id_employee']; ?>
" class="chkbox_emp"></td>
                                <td onclick="empDetail('<?php echo $this->_tpl_vars['x']['id_employee']; ?>
');" style="cursor:pointer;">
                                    <?php if ($this->_tpl_vars['x']['avatar'] == ''): ?>
                                        <img src="http://localhost/simplehrm/templates/css_theme/img/avatar/search/hrm_<?php if ($this->_tpl_vars['x']['gender'] == M): ?>male.jpg<?php else: ?>female.jpg<?php endif; ?>" title="Profile Pic">
                                    <?php else: ?>
                                        <img src="http://localhost/simplehrm/image/thumb4_search/avatar/<?php echo $this->_tpl_vars['x']['id_employee']; ?>
_<?php echo $this->_tpl_vars['x']['avatar']; ?>
" title="Profile Pic">
                                    <?php endif; ?>
                                 </td>
                                 <td onclick="empDetail('<?php echo $this->_tpl_vars['x']['id_employee']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['x']['name']; ?>
" align="left"><b><?php echo $this->_tpl_vars['x']['name']; ?>
</b></td>
                                 <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['x']['job_title_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)))) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
</td>
                                 <td><?php if ($this->_tpl_vars['x']['joined_date'] == '0000-00-00'): ?>NA<?php else:  echo ((is_array($_tmp=$this->_tpl_vars['x']['joined_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y"));  endif; ?></td>
                                 <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['x']['work_email'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
</td>
                                 <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['x']['work_phone'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
</td>
                                 <td>
                                    <?php if ($this->_tpl_vars['sm']['res_terminate'][$this->_tpl_vars['x']['id_employee']]): ?>
                                        <a style="cursor:pointer;" onclick="showTerminateReason('<?php echo $this->_tpl_vars['x']['id_employee']; ?>
');" title="See Details"><?php echo $this->_tpl_vars['emp_sts']['2']; ?>
</a>
                                    <?php else: ?>
                                        <?php echo $this->_tpl_vars['emp_sts'][$this->_tpl_vars['x']['emp_status']]; ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                           <?php endfor; endif; ?> 
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
                    	<br><div align="center">No employees found.</div><br>
                    <?php endif; ?>
                </div>
                <div class="txtbg_btm_sml fltlft"></div>
                <div class="clrbth"></div>
        </div>
    </div>
    <div class="btm"></div>
</div>
<?php echo '
<script type="text/javascript">
	var msg = \'';  echo $_SESSION['amsg'];  echo '\';
	callmsg(msg);
	$(document).ready(function(){
		$(\'#employee_name\').focus(function(){
			var emp_ser=$(\'#employee_name\').val();
			if(emp_ser==\'Search\'){
				$(this).val("");
			  }
		  }).blur(function(){
			var emp_ser=$(\'#employee_name\').val();
			if(emp_ser==\'\'){
				$(this).val("");
			  }
	 	 });
		//For Autocomplete
	    	$("#employee_name").autocomplete(\'http://localhost/simplehrm/index.php/employee/autoEmployeeName/ce-0-for-auto\', {scrollHeight: 380,autoPrefill: false,scroll:true });		
		$("#employee_name").result(function(event, data, formatted) {
			cShowActivity(\'\');
			if(data) {
				var empId = data[1].split("::");
   				if(check_JSsession(empId[1],1)) {
					$(\'#employee_name\').val(empId[1]);
					if(empId[1]!="No record"){
						cHideActivity();
						window.location.href="http://localhost/simplehrm/index.php/employee/employeeDetail/id-"+empId[0];
					 }
				 }				
		 	 }
	 	 });
	 });
	function addEmployee(){
		cShowActivity(\'\');
		var url = \'http://localhost/simplehrm/index.php/\';
		$.post(url,{page:\'employee\',choice:\'addEmployee\',ce:0 },function(res){
			if(check_JSsession(res,1)) {
				show_fancybox(res);
			 }
		 });
	 }
	function checkUncheck(cls){
		if(document.getElementById("chk_all").checked==true){
			$(\'.\'+cls).each(function(){	$(this).attr(\'checked\',\'checked\');   });
		 }else{
			$(\'.\'+cls).each(function(){	$(this).removeAttr(\'checked\');	  });
		 }
	 }
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
			jqueryAlert("Select at least one employee.");
			return false;
		 }else{
			if(chc==\'\'){
				chc=jqueryConfirm("Are you sure want to delete selected employee(s) ?","deleteAll",cls);
			 }
			if(chc){	
					searchEmployeeList(\'for_del\',\'\',keys,qs);
					return true;
			 }else{
					return false;
			 }
		 }
		
	 }
	function showTerminateReason(id){
		cShowActivity(\'\');
		var url = \'http://localhost/simplehrm/index.php/\';
		$.post(url,{page:\'employee\',choice:\'terminateEmp\',ce:0,id:id,flag:\'detail\' },function(res){
			show_fancybox(res);
		 });
	 }
</script>
'; ?>


<!-- Template: employee/employeeList.tpl.html End --> 