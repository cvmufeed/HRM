<?php /* Smarty version 2.6.7, created on 2017-08-24 10:54:38
         compiled from report/employeeJoiningsList.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'report/employeeJoiningsList.tpl.html', 67, false),array('modifier', 'date_format', 'report/employeeJoiningsList.tpl.html', 77, false),array('modifier', 'capitalize', 'report/employeeJoiningsList.tpl.html', 79, false),array('modifier', 'default', 'report/employeeJoiningsList.tpl.html', 79, false),)), $this); ?>

<!-- Template: report/employeeJoiningsList.tpl.html Start 24/08/2017 10:54:38 --> 
 <?php $this->assign('emp_sts', $this->_tpl_vars['util']->get_values_from_config('EMPLOYMENT_STATUS'));  $this->assign('m', $this->_tpl_vars['sm']['next_prev']->module);  if (defined ( @LINK_SEPARATOR )): ?>
	<?php $this->assign('sep', @LINK_SEPARATOR);  else: ?>
	<?php $this->assign('sep', "-");  endif; ?>

	<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
    	<div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft">
                <div class="fltlft">Employees list (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)</div>
                <div class="fltrht">
                </div>
                <div class="clear"></div>
            <input type="hidden" name="qstart" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" id="qstart">
            <input type="hidden" name="rshow" value="<?php echo $this->_tpl_vars['sm']['show']; ?>
" id="rshow">
            <input type="hidden" name="rtot" value="<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
" id="rtot">
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
                                <th class="email">Profile Pic</th>
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
 <?php if (($this->_foreach['foric']['iteration'] == $this->_foreach['foric']['total'])): ?>brdr_none<?php endif; ?>" title="Click on <?php echo $this->_tpl_vars['item']['0']; ?>
 to sort">
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
                            <td onclick="empDetail('<?php echo $this->_tpl_vars['x']['id_employee']; ?>
');" style="cursor:pointer;">
                                    <?php if ($this->_tpl_vars['x']['avatar'] == ''): ?>
                                        <img src="http://localhost/simplehrm/templates/css_theme/img/avatar/search/hrm_<?php if ($this->_tpl_vars['x']['gender'] == M): ?>male.jpg<?php else: ?>female.jpg<?php endif; ?>" title="Profile Pic">&emsp;
                                        
                                    <?php else: ?>
                                        <img src="http://localhost/simplehrm/image/thumb4_search/avatar/<?php echo $this->_tpl_vars['x']['id_employee']; ?>
_<?php echo $this->_tpl_vars['x']['avatar']; ?>
" title="Profile Pic" style="height:50px;width:50px;">
                                    <?php endif; ?>
                            </td>
                            <td onclick="empDetail('<?php echo $this->_tpl_vars['x']['id_employee']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['x']['name']; ?>
"><b><?php echo $this->_tpl_vars['x']['name']; ?>
</b></td>
                            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['joined_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B ,%Y") : smarty_modifier_date_format($_tmp, "%B ,%Y")); ?>
</td>
                            <td align="left"><?php echo $this->_tpl_vars['x']['annual_sal']; ?>
</td>
                            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['x']['job_title_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)))) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
</td>
                            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['sm']['res_team'][$this->_tpl_vars['x']['team']])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)))) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
</td>
                            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['sm']['res_department'][$this->_tpl_vars['x']['department']])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)))) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
</td>
                            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['sm']['res_div'][$this->_tpl_vars['x']['division']])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)))) ? $this->_run_mod_handler('default', true, $_tmp, 'NA') : smarty_modifier_default($_tmp, 'NA')); ?>
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
                    <br><div align="center">No employees found.</div><br>
                <?php endif; ?>
                </div>
                <div class="txtbg_btm fltlft"></div>
                <div class="clrbth"></div>
        </div>
    </div>
    <div class="cont_bg_btm"></div>
</div>

<!-- Template: report/employeeJoiningsList.tpl.html End --> 