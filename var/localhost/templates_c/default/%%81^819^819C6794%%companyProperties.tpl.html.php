<?php /* Smarty version 2.6.7, created on 2017-08-24 10:48:56
         compiled from report/companyProperties.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'report/companyProperties.tpl.html', 59, false),)), $this); ?>
<?php if (defined ( @LINK_SEPARATOR )): ?>
	<?php $this->assign('sep', @LINK_SEPARATOR);  else: ?>
	<?php $this->assign('sep', "-");  endif; ?>
<div id="report_companyProperties">
	<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
    	<div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft">
                <div class="fltlft">
                	 Company Properties List (<?php echo $this->_tpl_vars['sm']['next_prev']->total; ?>
)
                </div>
                <div class="fltrht">
                </div>
                <div class="clear"></div>
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
                            <?php $this->_foreach['foric'] = array('total' => count($_from = (array)$this->_tpl_vars['sm']['field']), 'iteration' => 0);
if ($this->_foreach['foric']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['foric']['iteration']++;
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
                                <th class="email <?php if (($this->_foreach['foric']['iteration'] == $this->_foreach['foric']['total'])): ?>brdr_none<?php endif; ?>">
                                    <?php if ($this->_tpl_vars['item']['1'] != 0): ?>
                                    <?php if ($this->_tpl_vars['sm']['ajax']): ?>
                                    <a href="javascript:get_next_page('http://localhost/simplehrm/<?php echo $this->_tpl_vars['sm']['uri'];  echo $this->_tpl_vars['sep']; ?>
sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
',0,0,'<?php echo $_REQUEST['page']; ?>
_<?php echo $_REQUEST['choice']; ?>
')"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                    <?php else: ?>
                                    <a href="http://localhost/simplehrm/<?php echo $this->_tpl_vars['sm']['uri'];  echo $this->_tpl_vars['sep']; ?>
sort_by<?php echo $this->_tpl_vars['sep'];  echo $this->_tpl_vars['key']; ?>
"><?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?></a>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <?php if ($this->_tpl_vars['item'] != ""):  echo $this->_tpl_vars['item']['0'];  else:  echo $this->_tpl_vars['key'];  endif; ?>
                                    <?php endif; ?>
                                </th>
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
');" style="cursor:pointer;"><b><?php echo $this->_tpl_vars['x']['name']; ?>
</b></td>
                                <td><?php echo $this->_tpl_vars['x']['property_name']; ?>
</td>
                                <td><?php echo $this->_tpl_vars['x']['serial_no']; ?>
</td>
                                <td><?php echo $this->_tpl_vars['x']['notes']; ?>
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
                        <div>Currently no properties found.</div>
                    <?php endif; ?>
                </div>
                <div class="txtbg_btm fltlft"></div>
                <div class="clrbth"></div>
        </div>
    </div>
    <div class="cont_bg_btm"></div>
</div>
</div>