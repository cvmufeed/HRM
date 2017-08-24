<?php /* Smarty version 2.6.7, created on 2017-08-24 10:51:27
         compiled from setting/listing.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'explode', 'setting/listing.tpl.html', 72, false),array('modifier', 'cat', 'setting/listing.tpl.html', 74, false),array('modifier', 'escape', 'setting/listing.tpl.html', 90, false),array('function', 'html_radios', 'setting/listing.tpl.html', 76, false),array('function', 'html_checkboxes', 'setting/listing.tpl.html', 79, false),array('function', 'html_options', 'setting/listing.tpl.html', 82, false),)), $this); ?>

<!-- Template: setting/listing.tpl.html Start 24/08/2017 10:51:27 --> 
 <script type="text/javascript" src="http://localhost/simplehrm/libsext/js/reorder.js"></script>
<script type="text/javascript" src="http://localhost/simplehrm/libsext/js/table_dnd.js"></script>
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/setting.css"/>
<?php if ($this->_tpl_vars['sm']['res']): ?>
<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
        <div class="cont_hdr1 fltlft">
            <div class="cont_hdr_lft fltlft"></div>
            <div class="cont_hdr_mdl1 fltlft">
                <div class="fltlft">
                   Configuration settings 
                </div>
                <div class="fltrht mrgtp-5">
                    <input id="collapse" type="button" value="Expand All"/>
                    <!--<input  type="button" onclick="addNew('http://localhost/simplehrm/index.php/page-setting-choice-add-ce-0');" value="Add new" >-->
                    <span id="chk_unchk"><input  type="button" onclick="checkAll(1);" value="Check All" ></span>
                    <input  type="button" onclick="deleteKey('http://localhost/simplehrm/index.php/page-setting-choice-delete_config-ce-0','');" value="Delete" />
                </div>
                <div class="clear"></div>
            </div>    	        
            <div class="cont_hdr_rht fltlft"></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="cont_txt">
            <div class="txtbg_top fltlft"></div>
            <div class="txtbg_mdl fltlft">


<div>
<?php unset($this->_sections['setting']);
$this->_sections['setting']['name'] = 'setting';
$this->_sections['setting']['loop'] = is_array($_loop=$this->_tpl_vars['sm']['res']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['setting']['show'] = true;
$this->_sections['setting']['max'] = $this->_sections['setting']['loop'];
$this->_sections['setting']['step'] = 1;
$this->_sections['setting']['start'] = $this->_sections['setting']['step'] > 0 ? 0 : $this->_sections['setting']['loop']-1;
if ($this->_sections['setting']['show']) {
    $this->_sections['setting']['total'] = $this->_sections['setting']['loop'];
    if ($this->_sections['setting']['total'] == 0)
        $this->_sections['setting']['show'] = false;
} else
    $this->_sections['setting']['total'] = 0;
if ($this->_sections['setting']['show']):

            for ($this->_sections['setting']['index'] = $this->_sections['setting']['start'], $this->_sections['setting']['iteration'] = 1;
                 $this->_sections['setting']['iteration'] <= $this->_sections['setting']['total'];
                 $this->_sections['setting']['index'] += $this->_sections['setting']['step'], $this->_sections['setting']['iteration']++):
$this->_sections['setting']['rownum'] = $this->_sections['setting']['iteration'];
$this->_sections['setting']['index_prev'] = $this->_sections['setting']['index'] - $this->_sections['setting']['step'];
$this->_sections['setting']['index_next'] = $this->_sections['setting']['index'] + $this->_sections['setting']['step'];
$this->_sections['setting']['first']      = ($this->_sections['setting']['iteration'] == 1);
$this->_sections['setting']['last']       = ($this->_sections['setting']['iteration'] == $this->_sections['setting']['total']);
?>
<?php $this->assign('x', $this->_tpl_vars['sm']['res'][$this->_sections['setting']['index']]); ?>
    <?php if ($this->_tpl_vars['sm']['res'][$this->_sections['setting']['index_prev']]['name'] != $this->_tpl_vars['x']['name']): ?>
            <div class="div_head">
            	<div class="fl">
                	<b class="sign" style="font-size:16px; margin-left:5px">+</b>
                </div>
                
                <div class="fl">
                	<b>&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['x']['name']; ?>
</b>
                </div>
                <div class="fr"><a href="javascript:void(0);" onclick="addNew('http://localhost/simplehrm/index.php/page-setting-choice-add-id_config-<?php echo $this->_tpl_vars['x']['id_config']; ?>
-ce-0');" class="rht_btn">Add new</a></div>
             </div>
            <div class="content table_margin" style="display:none; overflow:hidden">
<?php echo '
    <script type="text/javascript">
    $(document).ready(function(){
        var curl=\'http://localhost/simplehrm/index.php/setting/reorder?tab=\';
        '; ?>

        new callreorder("tab<?php echo $this->_tpl_vars['x']['name']; ?>
","dragHandle",curl,"showDragHandle","class1");
        <?php echo '
     });
    </script>
'; ?>

<div class="fr" style="margin-top:10px;margin-right:5px">
    
    &emsp;&emsp;
</div>
            <form action="javascript:void(0);" id="setting_<?php echo $this->_tpl_vars['x']['name']; ?>
" name="setting_<?php echo $this->_tpl_vars['x']['name']; ?>
" method="post" onsubmit="updateConfig('http://localhost/simplehrm/index.php/page-setting-choice-update_config','<?php echo $this->_tpl_vars['x']['name']; ?>
')">
            <input type="hidden" name="sectype" value="<?php echo $this->_tpl_vars['x']['name']; ?>
" />
            <table align="center" id="tab<?php echo $this->_tpl_vars['x']['name']; ?>
" class="tbl_lstin" width="102%">
        <?php endif; ?>
        <tr class="nodrag" id="<?php echo $this->_tpl_vars['x']['id_config']; ?>
">
<td class="dragHandle" style="width:10px" title="Drag"></td>
<td><input type="checkbox" value="<?php echo $this->_tpl_vars['x']['id_config']; ?>
" class="chkbox" id="id_chk<?php echo $this->_tpl_vars['x']['id_config']; ?>
" /></td>
            <td class="ttop" style="width:20%; text-align:right" align="right"><?php echo $this->_tpl_vars['x']['ckey']; ?>
</td>
            <td class="ttop" width="60%">
                <div class="fltlft">
                    <?php $this->assign('f_key', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['x']['f_key']) : explode($_tmp, $this->_tpl_vars['x']['f_key']))); ?>
                    <?php $this->assign('f_value', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['x']['f_value']) : explode($_tmp, $this->_tpl_vars['x']['f_value']))); ?>
                    <?php $this->assign('name_field', ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['x']['name'])) ? $this->_run_mod_handler('cat', true, $_tmp, '[') : smarty_modifier_cat($_tmp, '[')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['x']['id_config']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['x']['id_config'])))) ? $this->_run_mod_handler('cat', true, $_tmp, ']') : smarty_modifier_cat($_tmp, ']'))); ?>
                    <?php if ($this->_tpl_vars['x']['f_type'] == 'radio'): ?>
                        <span><?php echo smarty_function_html_radios(array('name' => $this->_tpl_vars['name_field'],'values' => $this->_tpl_vars['f_key'],'output' => $this->_tpl_vars['f_value'],'selected' => $this->_tpl_vars['x']['value']), $this);?>
</span>
                    <?php elseif ($this->_tpl_vars['x']['f_type'] == 'checkbox'): ?>
                        <?php $this->assign('x_value', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['x']['value']) : explode($_tmp, $this->_tpl_vars['x']['value']))); ?>
                        <span><?php echo smarty_function_html_checkboxes(array('name' => $this->_tpl_vars['name_field'],'values' => $this->_tpl_vars['f_key'],'output' => $this->_tpl_vars['f_value']), $this);?>
</span>
                    <?php elseif ($this->_tpl_vars['x']['f_type'] == 'dropdown'): ?>							
                        <select name="<?php echo $this->_tpl_vars['name_field']; ?>
">
                            <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['f_key'],'output' => $this->_tpl_vars['f_value'],'selected' => $this->_tpl_vars['x']['value']), $this);?>

                        </select>
                    <?php else: ?>
                        <input type="text" name="<?php echo $this->_tpl_vars['name_field']; ?>
" value="<?php echo $this->_tpl_vars['x']['value']; ?>
"/>
                    <?php endif; ?>
                </div>
                <?php if ($this->_tpl_vars['x']['comment']): ?>
                <div class="fltlft" style="padding:3px">
                    <a href="javascript:void(0);" class="comment" onmouseover="return overlib('<?php echo ((is_array($_tmp=$this->_tpl_vars['x']['comment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',CAPTION, 'Comment', CLOSECLICK,CSSCLASS,FGCLASS,'fgClass',BGCLASS,'bgClass',CLOSEFONTCLASS,'capfontClass','CAPTIONFONTCLASS','fontclass',FOLLOWMOUSE);" onmouseout="return nd();" style="text-decoration:none"><img src="http://localhost/simplehrm/templates/css_theme/img/help_sign.gif" alt="help"/></a>
                </div>
                <?php endif; ?>
              
                <?php if ($this->_tpl_vars['sm']['res'][$this->_sections['setting']['index_next']]['name'] != $this->_tpl_vars['x']['name']): ?>
                    </td>
                    <td width="20%" valign="bottom"><input class="login_btn fltrht" type="submit" value="Update" name="submit"/></td>
                    </tr>
                    </table>
                    
                    </form>
                    </div>
    <?php else: ?>   
    </td>
    </tr>
    <?php endif; ?>
<?php endfor; endif; ?>
</div>
<?php else: ?>
	<center><b>No records found</b></center>
<?php endif; ?>





            </div>
            <div class="txtbg_btm fltlft"></div>
            <div class="clrbth"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="cont_bg_btm"></div>
</div>	
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<?php echo '
<script type="text/javascript">
	//$("#target").html(\'';  echo $_SESSION['raise_message']['global'];  echo '\');
 function updateConfig(url,id){
	cShowActivity(\'1\');
 	var fval=$("#setting_"+id).serialize();
	url+="-ce-0?"+fval;
 	$.post(url,function(response){
		cHideActivity();
		callmsg("Successfully Updated");//showmsg(\'divid\',\'error message\');
		//window.location.href=response;
		$("#container").html(response);
	 });
  }
 function addNew(url){
	cShowActivity(\'\');
	$.post(url,function(response){
		//$.fancybox(response,{centerOnScroll:true,hideOnOverlayClick:false });
		show_fancybox(response);
	 });
  }
 $(\'#collapse\').click(function(){
	var txt=$(\'#collapse\').attr(\'value\');
	if(txt==\'Collapse All\'){
		$(\'.table_margin\').slideUp(1000);
		$(\'#collapse\').attr(\'value\',\'Expand All\');
		$(\'.sign\').html(\'+\');

	  }
	else if(txt==\'Expand All\'){
		$(\'.table_margin\').slideDown(1000);
		$(\'#collapse\').attr(\'value\',\'Collapse All\');
		$(\'.sign\').html(\'-\');	
	  }
  });
 $(document).ready(function(){
 	$(\'table#tab\').css({background:\'none\' });
  });
 $(\'.div_head\').click(function(){
	var txt=$(\'.sign\',this).html();
	if(txt==\'-\'){
		$(this).next(\'.table_margin\').slideUp(\'slow\');
		$(\'.sign\',this).html(\'+\');
		$(\'#collapse\').attr(\'value\',\'Expand All\');
	 }else if(txt==\'+\'){
		$(this).next(\'.table_margin\').slideDown(\'slow\');
		$(\'.sign\',this).html(\'-\');
		$(\'#collapse\').attr(\'value\',\'Collapse All\');
	 }
  });
 function checkAll(c){
	$(\'.chkbox\').each(function(){
		if(c){
			$(this).attr(\'checked\',\'checked\');
			$("#chk_unchk").html(\'<input  type="button" onclick="checkAll(0);" value="Uncheck All" >\');
		 }else{
			$(this).removeAttr(\'checked\');
			$("#chk_unchk").html(\'<input  type="button" onclick="checkAll(1);" value="Check All" >\');
		 }
	 });
	var txt=$(\'#collapse\').attr(\'value\');
	if(txt==\'Expand All\'){
		$(\'.table_margin\').slideDown(1000);
		$(\'#collapse\').attr(\'value\',\'Collapse All\');
		$(\'.sign\').html(\'-\');	
	 }else if(txt==\'Collapse All\' && !c){
		$(\'.table_margin\').slideUp(1000);
		$(\'#collapse\').attr(\'value\',\'Expand All\');
		$(\'.sign\').html(\'+\');		
	 }
  }
 function deleteKey(url,chc){
	var keys=\'\';
	$(\'.chkbox\').each(function(){
		if($(this).is(\':checked\'))
			keys +=$(this).val()+",";
	 });
	if(!keys){
		jqueryAlert("Please choose records to delete.");
		return false;
	 }else{
		if(chc==\'\'){
			chc=jqueryConfirm("Do you really want to delete selected records?","deleteKey",url);
		 }
		if(!chc)
			return false;
	 }
	cShowActivity(\'1\');
	$.post(url,{\'keys\':keys }, function(res){
		window.location.href=res;
	 });
  }
</script> 
'; ?>

<?php echo '
<style type="text/css">
.class1{
	background:#3366FF;
 }
.showDragHandle{	
	background:#FF0000;
	cursor:move;
 }
.altbox .content table tr.even td {background: #fff; }
</style>
'; ?>


<!-- Template: setting/listing.tpl.html End --> 