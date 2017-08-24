<?php /* Smarty version 2.6.7, created on 2017-08-24 10:51:02
         compiled from setting/companyInfo.tpl.html */ ?>

<!-- Template: setting/companyInfo.tpl.html Start 24/08/2017 10:51:02 --> 
 <?php echo '
<script type="text/javascript">
	function editCompanyInfo(){
		var url="http://localhost/simplehrm/index.php/setting/companyInfo/";
		$.post(url,{edit:1,ce:0 },function(res){
			if(check_JSsession(res,1)) {
				$(\'#companyInfoList\').hide();
				$(\'#editCompanyInfo\').show();
				$("#editCompanyInfo").html(res);
			 }
		  });
	 }	
	function cancelEdit(){
		$(\'#companyInfoList\').show();
		$(\'#editCompanyInfo\').hide();
	  }	
</script>
'; ?>

<?php $this->assign('curr', $this->_tpl_vars['util']->get_values_from_config('CURRENCY')); ?>
<div id="companyInfo">
	<div id="companyInfoList">
        <div class="cont">
            <div class="cont_bg_top"></div>
            <div class="cont_bg_mdl" style="padding-bottom:10px;">
                <div class="cont_hdr1 fltlft">
                    <div class="cont_hdr_lft fltlft"></div>
                    <div class="cont_hdr_mdl1 fltlft" style="width:885px;">Company Information</div>
                    <?php $this->assign('company', $this->_tpl_vars['sm']['company_res']); ?>
                    <div class="cont_hdr_rht fltlft"></div>
                </div>
                <div class="clrbth"></div>
<div class="cont_txt" style="margin-left:20px;">
                        <div class="txtbg_top fltlft"></div>
                        <div class="txtbg_mdl fltlft">
                <table border="0" class="listing_tbl">
                        <tr>
                            <td width="20%">Company name: </td>
                            <td align="80%"><?php echo $this->_tpl_vars['sm']['res']['company_name']; ?>
</td>
                        </tr>
                        <tr>
                            <td>Company information: </td>
                            <td><?php echo $this->_tpl_vars['sm']['res']['company_info']; ?>
</td>
                        </tr>
                        <tr>
                            <td>Number of employees: </td>
                            <td><?php echo $this->_tpl_vars['sm']['res']['cnt']; ?>
</td>
                        </tr>
                        <tr>
                            <td>Company logo: </td>
                            <td><img src='http://localhost/simplehrm/image/orig/companylogo/<?php echo $this->_tpl_vars['sm']['res']['id_company']; ?>
_<?php echo $this->_tpl_vars['sm']['res']['logo']; ?>
'/></td>
                        </tr>
                        <tr>
                            <td>Address: </td>
                            <td><?php echo $this->_tpl_vars['sm']['res']['address']; ?>
</td>
                        </tr>
                        <tr>
                            <td>Tax ID: </td>
                            <td><?php echo $this->_tpl_vars['sm']['res']['tax_id']; ?>
</td>
                        </tr>
                        <tr>
                            <td>Twitter Id: </td>
                            <td><a href=http://<?php echo $this->_tpl_vars['sm']['res']['twitter_id']; ?>
><?php echo $this->_tpl_vars['sm']['res']['twitter_id']; ?>
</a></td>
                        </tr>
                        <tr>
                            <td>Facebook Id: </td>
                            <td><a href=http://<?php echo $this->_tpl_vars['sm']['res']['facebook_id']; ?>
><?php echo $this->_tpl_vars['sm']['res']['facebook_id']; ?>
</a></td>
                        </tr>
                        <tr>
                            <td>Linkedin ID: </td>
                            <td><a href=http://<?php echo $this->_tpl_vars['sm']['res']['linkedin_id']; ?>
><?php echo $this->_tpl_vars['sm']['res']['linkedin_id']; ?>
</a></td>
                        </tr>
                        <tr>
                            <td>Company e-mail: </td>
                            <td><a href=mailto://<?php echo $this->_tpl_vars['sm']['res']['email_id']; ?>
><?php echo $this->_tpl_vars['sm']['res']['email_id']; ?>
</a></td>
                        </tr>
                        <tr>
                            <td>HQ timezone:</td>
                            <td><?php echo $this->_tpl_vars['company']['timezone_text']; ?>
</td>
                        </tr>
                        <tr>
                            <td>Currency:</td>
                            <td><?php echo $this->_tpl_vars['company']['currency']; ?>
 (<?php echo $this->_tpl_vars['curr'][$this->_tpl_vars['company']['currency']]; ?>
)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="button" name="edit" value="Edit" onclick="editCompanyInfo();" class="login_btn" /></td>
                        </tr>  
                    </table>
                    
                     </div>
                        <div class="txtbg_btm fltlft"></div>
                        <div class="clrbth"></div>
</div>
            </div>
            <div class="cont_bg_btm"></div>
        </div>
	</div>
	<div id="editCompanyInfo" style="display:none;"></div>
</div>

<!-- Template: setting/companyInfo.tpl.html End --> 