<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:28
         compiled from employee/autoList.tpl.html */ ?>
<?php if ($this->_tpl_vars['sm']['flag'] == 1): ?>
	<?php if (count($_from = (array)$this->_tpl_vars['sm']['data'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<span class="fcolor"><?php echo $this->_tpl_vars['item']; ?>
</span>
	<?php endforeach; else: ?>
		<span class="fcolor">No results</span>
	<?php endif; unset($_from);  endif;  if ($this->_tpl_vars['sm']['flag'] == 2): ?>
	<?php if ($this->_tpl_vars['sm']['data']): ?>
		<?php unset($this->_sections['emp']);
$this->_sections['emp']['name'] = 'emp';
$this->_sections['emp']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['emp']['show'] = true;
$this->_sections['emp']['max'] = $this->_sections['emp']['loop'];
$this->_sections['emp']['step'] = 1;
$this->_sections['emp']['start'] = $this->_sections['emp']['step'] > 0 ? 0 : $this->_sections['emp']['loop']-1;
if ($this->_sections['emp']['show']) {
    $this->_sections['emp']['total'] = $this->_sections['emp']['loop'];
    if ($this->_sections['emp']['total'] == 0)
        $this->_sections['emp']['show'] = false;
} else
    $this->_sections['emp']['total'] = 0;
if ($this->_sections['emp']['show']):

            for ($this->_sections['emp']['index'] = $this->_sections['emp']['start'], $this->_sections['emp']['iteration'] = 1;
                 $this->_sections['emp']['iteration'] <= $this->_sections['emp']['total'];
                 $this->_sections['emp']['index'] += $this->_sections['emp']['step'], $this->_sections['emp']['iteration']++):
$this->_sections['emp']['rownum'] = $this->_sections['emp']['iteration'];
$this->_sections['emp']['index_prev'] = $this->_sections['emp']['index'] - $this->_sections['emp']['step'];
$this->_sections['emp']['index_next'] = $this->_sections['emp']['index'] + $this->_sections['emp']['step'];
$this->_sections['emp']['first']      = ($this->_sections['emp']['iteration'] == 1);
$this->_sections['emp']['last']       = ($this->_sections['emp']['iteration'] == $this->_sections['emp']['total']);
?>
		<?php $this->assign('x', $this->_tpl_vars['sm']['data'][$this->_sections['emp']['index']]); ?>
			<a href="http://localhost/simplehrm/index.php/employee/profile/id-<?php echo $this->_tpl_vars['x']['id_employee']; ?>
" style="text-decoration:none; border:0;"><?php if ($this->_tpl_vars['x']['avatar'] != ''): ?><img src="http://localhost/simplehrm/image/thumb4_search/avatar/<?php echo $this->_tpl_vars['x']['id_employee']; ?>
_<?php echo $this->_tpl_vars['x']['avatar']; ?>
" title="Profile Pic" style="height:50px;width:50px;"/><?php else: ?><img src="http://localhost/simplehrm/templates/css_theme/img/avatar/search/hrm_<?php if ($this->_tpl_vars['x']['gender'] == M): ?>male.jpg<?php else: ?>female.jpg<?php endif; ?>" title="Profile Pic"/><?php endif; ?>&emsp;<?php echo $this->_tpl_vars['x']['name']; ?>
</a>|<?php echo $this->_tpl_vars['x']['id_employee']; ?>
::<?php echo $this->_tpl_vars['x']['name']; ?>

		<?php endfor; endif; ?>
	<?php else: ?>
		<span class="fcolor">No records</span>|''::No record
	<?php endif;  endif; ?>