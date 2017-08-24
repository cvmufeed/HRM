<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:23
         compiled from employee/latestAddModifyViewEmp.tpl.html */ ?>

<!-- Template: employee/latestAddModifyViewEmp.tpl.html Start 24/08/2017 10:53:23 --> 
 <?php if ($this->_tpl_vars['sm']['flag'] == 'view'): ?>
<div class="smlest_box">
	<div class="top"></div>
	<div class="mdl">
    	<?php if ($this->_tpl_vars['sm']['flag'] == 'view'): ?>
        	<div class="cont_hdr1 fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl1 fltlft" align="left">Recently viewed</div>
                <div class="cont_hdr_rht fltlft"></div>
            </div>
            <div class="clear"></div>
            <div class="wid84smlst">
                <?php if (count($_from = (array)$this->_tpl_vars['sm']['lviewedemp'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                    <p><a onclick="empDetail('<?php echo $this->_tpl_vars['key']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></p>
                <?php endforeach; else: ?>
                    <p>No employees found.</p>
                <?php endif; unset($_from); ?>
            </div>
        <?php else: ?>
            <div class="cont_hdr1 fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl1 fltlft" align="left">Recently added</div>
                <div class="cont_hdr_rht fltlft"></div>
            </div>
            <div class="clear"></div>	
            <div class="mrgn_lft">
            <?php if (count($_from = (array)$this->_tpl_vars['sm']['laddedemp'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <p><a onclick="empDetail('<?php echo $this->_tpl_vars['key']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></p>
            <?php endforeach; else: ?>
                <p>No employees found.</p>
            <?php endif; unset($_from); ?>
            </div>
            <div class="cont_hdr1 fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl1 fltlft" align="left">Recently modified</div>
                <div class="cont_hdr_rht fltlft"></div>
            </div>
            <div class="clear"></div>	
            <div class="mrgn_lft">
            <?php if (count($_from = (array)$this->_tpl_vars['sm']['lmodifiedemp'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <p><a onclick="empDetail('<?php echo $this->_tpl_vars['key']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></p>
            <?php endforeach; else: ?>
                <p>No employees found.</p>
            <?php endif; unset($_from); ?>
        </div>
        <?php endif; ?>
        <div class="clear"></div>	
    </div>
	<div class="btm"></div>
</div>
<?php else: ?>
<div class="latest">
    <div><b>Recently added employees</b></div>
    <div class="mrgn_lft">
    <?php if (count($_from = (array)$this->_tpl_vars['sm']['laddedemp'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    	<p><a onclick="empDetail('<?php echo $this->_tpl_vars['key']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></p>
	<?php endforeach; else: ?>
		<p>No employees found.</p>
	<?php endif; unset($_from); ?>
    </div>
</div>
<div class="latest">
    <div><b>Recently modified employees</b></div>
    <div class="mrgn_lft">
    	<?php if (count($_from = (array)$this->_tpl_vars['sm']['lmodifiedemp'])):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        	<p><a onclick="empDetail('<?php echo $this->_tpl_vars['key']; ?>
');" style="cursor:pointer;" title="See details of <?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></p>
        <?php endforeach; else: ?>
            <p>No employees found.</p>
        <?php endif; unset($_from); ?>
    </div>
</div>
<?php endif; ?>



<!-- Template: employee/latestAddModifyViewEmp.tpl.html End --> 