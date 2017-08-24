<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:50
         compiled from adminstration/reminderShow.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'adminstration/reminderShow.tpl.html', 8, false),)), $this); ?>

<!-- Template: adminstration/reminderShow.tpl.html Start 24/08/2017 10:50:50 --> 
 <div class="latest">
    <?php if ($this->_tpl_vars['sm']['res_emp']): ?><div><b>Upcoming Birthdays</b></div><?php endif; ?>
    <div class="mrgn_lft">
	<?php unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['res_emp']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
	<?php $this->assign('x', $this->_tpl_vars['sm']['res_emp'][$this->_sections['s1']['index']]); ?>
		<p><?php echo $this->_tpl_vars['x']['name']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['dob'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d %B") : smarty_modifier_date_format($_tmp, "%d %B")); ?>
)</p>
	<?php endfor; endif; ?>
    </div>
</div>
<div class="latest">
	<?php if ($this->_tpl_vars['sm']['res_leave']): ?><div><b>Leave request from</b></div><?php endif; ?>
    <div class="mrgn_lft">
	<?php unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['res_leave']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
	<?php $this->assign('l', $this->_tpl_vars['sm']['res_leave'][$this->_sections['s1']['index']]); ?>
		<p><?php echo $this->_tpl_vars['l']['name']; ?>
</p>
	<?php endfor; endif; ?>
    </div>
</div>
<div class="latest">
	<?php if ($this->_tpl_vars['sm']['res_travel']): ?><div><b>Travel request from</b></div><?php endif; ?>
    <div class="mrgn_lft">
	<?php unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['res_travel']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
	<?php $this->assign('l', $this->_tpl_vars['sm']['res_travel'][$this->_sections['s1']['index']]); ?>
		<p><?php echo $this->_tpl_vars['l']['name']; ?>
</p>
	<?php endfor; endif; ?>
    </div>
</div>
<div class="latest">
	<?php if ($this->_tpl_vars['sm']['res_expense']): ?><div><b>Expense request from</b></div><?php endif; ?>
    <div class="mrgn_lft">
	<?php unset($this->_sections['ex1']);
$this->_sections['ex1']['name'] = 'ex1';
$this->_sections['ex1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['res_expense']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ex1']['show'] = true;
$this->_sections['ex1']['max'] = $this->_sections['ex1']['loop'];
$this->_sections['ex1']['step'] = 1;
$this->_sections['ex1']['start'] = $this->_sections['ex1']['step'] > 0 ? 0 : $this->_sections['ex1']['loop']-1;
if ($this->_sections['ex1']['show']) {
    $this->_sections['ex1']['total'] = $this->_sections['ex1']['loop'];
    if ($this->_sections['ex1']['total'] == 0)
        $this->_sections['ex1']['show'] = false;
} else
    $this->_sections['ex1']['total'] = 0;
if ($this->_sections['ex1']['show']):

            for ($this->_sections['ex1']['index'] = $this->_sections['ex1']['start'], $this->_sections['ex1']['iteration'] = 1;
                 $this->_sections['ex1']['iteration'] <= $this->_sections['ex1']['total'];
                 $this->_sections['ex1']['index'] += $this->_sections['ex1']['step'], $this->_sections['ex1']['iteration']++):
$this->_sections['ex1']['rownum'] = $this->_sections['ex1']['iteration'];
$this->_sections['ex1']['index_prev'] = $this->_sections['ex1']['index'] - $this->_sections['ex1']['step'];
$this->_sections['ex1']['index_next'] = $this->_sections['ex1']['index'] + $this->_sections['ex1']['step'];
$this->_sections['ex1']['first']      = ($this->_sections['ex1']['iteration'] == 1);
$this->_sections['ex1']['last']       = ($this->_sections['ex1']['iteration'] == $this->_sections['ex1']['total']);
?>
	<?php $this->assign('l', $this->_tpl_vars['sm']['res_expense'][$this->_sections['ex1']['index']]); ?>
		<p><?php echo $this->_tpl_vars['l']['name']; ?>
</p>
	<?php endfor; endif; ?>
    </div>
</div>
<div class="latest">
	<?php if ($this->_tpl_vars['sm']['res_leave']): ?><div><b>Reminders</b></div><?php endif; ?>
    <div class="mrgn_lft">
	<?php unset($this->_sections['s1']);
$this->_sections['s1']['name'] = 's1';
$this->_sections['s1']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['res_rem']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s1']['show'] = true;
$this->_sections['s1']['max'] = $this->_sections['s1']['loop'];
$this->_sections['s1']['step'] = 1;
$this->_sections['s1']['start'] = $this->_sections['s1']['step'] > 0 ? 0 : $this->_sections['s1']['loop']-1;
if ($this->_sections['s1']['show']) {
    $this->_sections['s1']['total'] = $this->_sections['s1']['loop'];
    if ($this->_sections['s1']['total'] == 0)
        $this->_sections['s1']['show'] = false;
} else
    $this->_sections['s1']['total'] = 0;
if ($this->_sections['s1']['show']):

            for ($this->_sections['s1']['index'] = $this->_sections['s1']['start'], $this->_sections['s1']['iteration'] = 1;
                 $this->_sections['s1']['iteration'] <= $this->_sections['s1']['total'];
                 $this->_sections['s1']['index'] += $this->_sections['s1']['step'], $this->_sections['s1']['iteration']++):
$this->_sections['s1']['rownum'] = $this->_sections['s1']['iteration'];
$this->_sections['s1']['index_prev'] = $this->_sections['s1']['index'] - $this->_sections['s1']['step'];
$this->_sections['s1']['index_next'] = $this->_sections['s1']['index'] + $this->_sections['s1']['step'];
$this->_sections['s1']['first']      = ($this->_sections['s1']['iteration'] == 1);
$this->_sections['s1']['last']       = ($this->_sections['s1']['iteration'] == $this->_sections['s1']['total']);
?>
	<?php $this->assign('y', $this->_tpl_vars['sm']['res_rem'][$this->_sections['s1']['index']]); ?>
		<p><?php echo $this->_tpl_vars['y']['reminder']; ?>
</p>
	<?php endfor; else: ?>
		<p>There are no reminders.</p>
	<?php endif; ?>
    </div>
</div>

<!-- Template: adminstration/reminderShow.tpl.html End --> 