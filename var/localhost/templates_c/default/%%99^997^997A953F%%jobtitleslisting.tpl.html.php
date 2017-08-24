<?php /* Smarty version 2.6.7, created on 2013-09-09 08:16:11
         compiled from setting/jobtitleslisting.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'setting/jobtitleslisting.tpl.html', 22, false),array('modifier', 'capitalize', 'setting/jobtitleslisting.tpl.html', 66, false),array('modifier', 'wordwrap', 'setting/jobtitleslisting.tpl.html', 70, false),array('modifier', 'escape', 'setting/jobtitleslisting.tpl.html', 73, false),array('function', 'cycle', 'setting/jobtitleslisting.tpl.html', 65, false),)), $this); ?>
<?php if (defined ( @LINK_SEPARATOR )): ?>
	<?php $this->assign('sep', @LINK_SEPARATOR); ?>
<?php else: ?>
	<?php $this->assign('sep', "-"); ?>
<?php endif; ?>
<div id="setting_jobtitles">
	<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
    	<div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft">
                <div class="fltlft">
                	 List of job titles (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)
                </div>
                <div class="fltrht">
                	<input type="button" name="addjob" value="Add" id="addjob" onclick="addjobtitle()"/>
                </div>
                <div class="clear"></div>
                <input type="hidden" name="start" id="start" value="<?php echo $this->_tpl_vars['sm']['next_prev']->start; ?>
" />
                <input type="hidden" name="cnt" id="cnt" value="<?php echo count($this->_tpl_vars['sm']['list']); ?>
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
                                    <a href="javascript:get_next_page('http://localhost/SHRMV22/<?php echo $this->_tpl_vars['sm']['uri'];  echo $this->_tpl_vars['sep']; ?>
sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
',0,0,'<?php echo $_REQUEST['page']; ?>
_<?php echo $_REQUEST['choice']; ?>
')"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                    <?php else: ?>
                                    <a href="http://localhost/SHRMV22/<?php echo $this->_tpl_vars['sm']['uri'];  echo $this->_tpl_vars['sep']; ?>
sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?>
                                    <?php endif; ?>
                                </th>
                                <?php endforeach; endif; unset($_from); ?>
                                <th class="email">Notes</th>
                            <th class="email">Employees</th>  
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
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['div_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</td>
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['dept_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</td>
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['team_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</td>
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['job_title_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</td>
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['x']['notes'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 40, "<br>") : smarty_modifier_wordwrap($_tmp, 40, "<br>")); ?>
</td>
                                <td align="center"><?php if ($this->_tpl_vars['sm']['res4'][$this->_tpl_vars['x']['id_job_title']]):  echo $this->_tpl_vars['sm']['res4'][$this->_tpl_vars['x']['id_job_title']];  else: ?>0<?php endif; ?></td>
                                <td>
                                    <a href="javascript:void(0);" onclick="edit_jobtitles(<?php echo $this->_tpl_vars['x']['id_job_title']; ?>
,'<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['job_title_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['id_team'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['div_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['dept_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['team_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['notes'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
',<?php echo $this->_tpl_vars['x']['id_department']; ?>
,<?php echo $this->_tpl_vars['x']['id_division']; ?>
)"><img src="http://localhost/SHRMV22/templates/images/blue/edit_img.png" alt="" title="Edit"/></a></td><td>
                                    <?php if (! $this->_tpl_vars['sm']['res4'][$this->_tpl_vars['x']['id_job_title']]): ?>
                                        <a href="javascript:void(0);" onclick="remove_jobtitle('<?php echo $this->_tpl_vars['x']['id_job_title']; ?>
','')"><img src="http://localhost/SHRMV22/templates/images/blue/delete_img.png" alt="" title="Delete"/></a>
                                    <?php endif; ?>		
                                </td>
                            </tr>
                        <?php endfor; endif; ?>
                        </tbody>
                    </table>
                    <div>
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
                    </div>
                    <?php else: ?>
                        <div>No Record found.</div>
                    <?php endif; ?>
                </div>
                <div class="txtbg_btm fltlft"></div>
                <div class="clrbth"></div>
        </div>
    </div>
    <div class="cont_bg_btm"></div>
</div>
</div>