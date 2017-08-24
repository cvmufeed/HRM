<?php /* Smarty version 2.6.7, created on 2017-08-24 10:49:33
         compiled from adminstration/reminderListing.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'adminstration/reminderListing.tpl.html', 67, false),array('modifier', 'date_format', 'adminstration/reminderListing.tpl.html', 69, false),array('modifier', 'default', 'adminstration/reminderListing.tpl.html', 143, false),)), $this); ?>
<?php if (defined ( @LINK_SEPARATOR )): ?>
	<?php $this->assign('sep', @LINK_SEPARATOR); ?>
<?php else: ?>
	<?php $this->assign('sep', "-"); ?>
<?php endif; ?>

	<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
    	<div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft">
                <div class="fltlft">
                	 Reminders list (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)
                </div>
                <div class="fltrht">
					<input type="button" name="addEditReminder" value="Add" onclick="addEditReminder('add','')"/>
                    <span id="createics">
                        <input type="button" value="Save as iCal" id="ical" name="ical" onclick="createics();" class="login_btn" style="font-size:11px"/>
                    </span>
                </div>
                <div class="clear"></div>
				<input type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" />
            </div>
            <div class="cont_hdr_rht fltlft"></div>
	        <div class="clrbth"></div>
        </div>
        <div class="clrbth"></div>
        <div class="cont_txt">
            	<div class="txtbg_top fltlft"></div>
                <div class="txtbg_mdl fltlft">
                <?php if ($this->_tpl_vars['sm']['list']): ?>
                    <table width="97%" cellpadding="0" cellspacing="0" border="0" align="center" class="tbl_listing" style="margin-bottom:25px;">
                        <thead>			
                            <tr>
                                <?php if (count($_from = (array)$this->_tpl_vars['sm']['field'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                    <?php if ($this->_tpl_vars['key'] == $_SESSION[$this->_tpl_vars['m']]['sort_by']): ?>
                                        <?php if ($_SESSION[$this->_tpl_vars['m']]['sort_order'] == 'ASC'): ?>
                                            <?php $this->assign('cls', 'asc'); ?>
                                        <?php else: ?>
                                            <?php $this->assign('cls', 'desc'); ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php $this->assign('cls', ""); ?>
                                    <?php endif; ?>
                                    <th class="email">
                                        <?php if ($this->_tpl_vars['item']['1'] != 0): ?>
                                            <?php if ($this->_tpl_vars['sm']['ajax']): ?>
                                                <div style="width:1px; background:#fff; height:20px; float:left; margin-left:-4px"></div>
                                                <a href="javascript:get_next_page('http://localhost/simplehrm/<?php echo $this->_tpl_vars['sm']['uri']; ?>
/sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
',0,0,'<?php echo $_REQUEST['page']; ?>
_<?php echo $_REQUEST['choice']; ?>
')"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                            <?php else: ?>
                                                <div style="width:1px; background:#fff; height:20px; float:left; margin-left:-4px"></div>
                                                <a href="http://localhost/simplehrm/<?php echo $this->_tpl_vars['sm']['uri']; ?>
/sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?>
                                        <?php endif; ?>
                                    </th>
                                <?php endforeach; endif; unset($_from); ?>
                                    <th class="email brdr_none">Action</th>
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
                                <td class="tl"><?php echo $this->_tpl_vars['x']['reminder']; ?>
</td>
                                <td class="tl"><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['reminder_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y %I:%M %p") : smarty_modifier_date_format($_tmp, "%d-%m-%Y %I:%M %p")); ?>
</td>
                                <td>
                                    <?php $this->assign('e', $this->_tpl_vars['x']['recurrence_status']); ?>
                                    <?php echo $this->_tpl_vars['sm']['duration'][$this->_tpl_vars['e']]; ?>

                                </td>
                                <td class="tl">
                                    <a href="javascript:void(0);" onclick=" return addEditReminder('edit','<?php echo $this->_tpl_vars['x']['id_reminder']; ?>
','<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
');"><img src="http://localhost/simplehrm/templates/images/blue/edit_img.png" alt="edit" title="Edit"/></a>
                                    &nbsp;&nbsp;<a href="javascript:void(0);" onclick="return delreminder('<?php echo $this->_sections['cur']['total']; ?>
','<?php echo $this->_tpl_vars['x']['id_reminder']; ?>
','');"><img src="http://localhost/simplehrm/templates/images/blue/delete_img.png" alt="delete" title="Delete"/></a>
                                    &nbsp;&nbsp;<a href="javascript:void(0);" id="status<?php echo $this->_sections['cur']['index']; ?>
" name="status<?php echo $this->_sections['cur']['index']; ?>
" onclick="return change_status('<?php echo $this->_sections['cur']['index']; ?>
','<?php echo $this->_tpl_vars['x']['id_reminder']; ?>
','');" style="cursor:pointer; color:#666"><?php if ($this->_tpl_vars['x']['status'] == 1): ?>Close<?php else: ?>Open<?php endif; ?></a>
                                </td>
                            </tr>			
                        <?php endfor; endif; ?>
                        </tbody>
                    </table>
                    <div align="center">
                        <?php if ($this->_tpl_vars['sm']['type'] == 'advance'): ?>
                            <div class="pagination_adv"><?php echo $this->_tpl_vars['sm']['next_prev']->generateadv(); ?>
</div>
                        <?php elseif ($this->_tpl_vars['sm']['type'] == 'box'): ?>
                            <div class="pagination_box"><?php echo $this->_tpl_vars['sm']['next_prev']->generate(); ?>
</div>
                        <?php elseif ($this->_tpl_vars['sm']['type'] == 'normal'): ?>
                            <div class="pagination"><?php echo $this->_tpl_vars['sm']['next_prev']->generate(); ?>
</div>
                        <?php elseif ($this->_tpl_vars['sm']['type'] == 'nextprev'): ?>
                            <div class="pagination"><?php echo $this->_tpl_vars['sm']['next_prev']->onlynextprev(); ?>
</div>
                        <?php elseif ($this->_tpl_vars['sm']['type'] == 'extra'): ?>
                            <div class="pagination_box"><?php echo $this->_tpl_vars['sm']['next_prev']->generateextra(); ?>
</div></div>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['sm']['type'] != 'no'): ?>
                                <div><?php echo $this->_tpl_vars['sm']['next_prev']->generate(); ?>
</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div>Sorry,currently system does not have any reminder.</div>
                <?php endif; ?>
                </div>
                <div class="txtbg_btm fltlft"></div>
                <div class="clrbth"></div>
        </div>
    </div>
    <div class="cont_bg_btm"></div>
</div>
<?php echo '
<script type="text/javascript">
var ch,id;
function addEditReminder(ch,id,qstart){
	var url="http://localhost/simplehrm/index.php/adminstration/addEditReminder/ce-0";
		cShowActivity(\'\');
		$.post(url,{id_reminder:id,ch:ch,qstart:qstart },function(res){
			show_fancybox(res);
		 });
 }
function delreminder(cur,id,chc){
	 var qstart=$("#start").val();
	 var url="http://localhost/simplehrm/index.php/adminstration/deleteReminder";
	 if(chc==\'\'){
		chc=jqueryConfirm("Do you really want to delete this record?","delreminder",cur,id);
	  }
	 if(chc){
		 cShowActivity(\'1\');
		 $.post(url,{ce:0,id:id,cur:cur,qstart:qstart,chk:1 },function(res){
			$("#target").html("Deleted sucessfully").show();
			setTimeout("$(\'#target\').hide()",2000);
			cHideActivity();
			$(\'#adminstration_reminders\').html(res);
		  });
	  }else
	 	return false;
 }
function change_status(itr,id,chc){
	 var status=$("#status"+itr).html();
	  if(chc==\'\'){
		chc=jqueryConfirm("Are you sure you want to "+status+" record?","change_status",itr,id);
	  }
	 if(chc){
		 var qstart=\'';  echo ((is_array($_tmp=@$_REQUEST['qstart'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0));  echo '\';
		 if(status==\'Open\'){
			var val=1;
			var x=\'Close\';
		  }else if(status==\'Close\'){
			var x=\'Open\';
			var val=2;
		  }
		 var url="http://localhost/simplehrm/index.php/adminstration/changeReminderStatus";
		 $.post(url,{ce:0,id:id,val:val,qstart:qstart },function(res){
			$("#status"+itr).html(x);
	 	 });
	 }
 }
</script>
'; ?>
