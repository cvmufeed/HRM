<?php /* Smarty version 2.6.7, created on 2017-08-24 10:50:50
         compiled from user/companyDashboard.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_mod', 'user/companyDashboard.tpl.html', 43, false),array('modifier', 'date_format', 'user/companyDashboard.tpl.html', 79, false),)), $this); ?>
<?php $this->_cache_serials['/home/mufeed/html/generatedata/simplehrm/flexycms/../var/localhost/templates_c/default/%%1B^1B9^1B955BEE%%companyDashboard.tpl.html.inc'] = 'd55231b3a6453978727e7b2c2ff8f1b3'; ?>
<!-- Template: user/companyDashboard.tpl.html Start 24/08/2017 10:50:50 --> 
 <?php echo '
	<script type="text/javascript">
		//fancyAlert("test");
		$(document).ready(function(res){
			var wel_flag = "';  echo $_SESSION['wel_flag'];  echo '";
			if(wel_flag){
				cShowActivity(\'\');
				var url = "http://localhost/simplehrm/";
				$.post(url,{page:\'user\',choice:\'welcomeCompany\',ce:0 },function(res){
					wel_flag = 0;
					show_fancybox(res);
				  });
			 }else{
				return true;
			 }
		 });
		function addEmployee(){
			cShowActivity(\'\');
			var url = \'http://localhost/simplehrm/index.php/\';
			$.post(url,{page:\'employee\',choice:\'addEmployee\',\'flg\':\'dash\',ce:0 },function(res){
				show_fancybox(res);
			 });
		 }
	</script>
'; ?>


<div class="cont">
    <div class="cont_bg_top"></div>
    <div class="cont_bg_mdl">
        <div align="center">
            <div class="ds_hdr">
            	Welcome back, <?php echo $_SESSION['company_name']; ?>
 (Administrator)<br/>
        	</div>
        </div>
        <div class="fltlft">
             <div class="cont_hdr fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl fltlft">Recently added or modified employees</div>
                <div class="cont_hdr_rht fltlft"></div>
                <div class="clear"></div>
                <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d55231b3a6453978727e7b2c2ff8f1b3#0}';}echo $this->_plugins['function']['get_mod'][0][0]->get_mod(array('mod' => 'employee','mgr' => 'employee','choice' => 'latestAddModifyViewEmp'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d55231b3a6453978727e7b2c2ff8f1b3#0}';}?>

                <br />


            </div>

            <div class="cont_hdr fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl fltlft">Reminders</div>
                <div class="cont_hdr_rht fltlft"></div>
                <div class="clear"></div>
                <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d55231b3a6453978727e7b2c2ff8f1b3#1}';}echo $this->_plugins['function']['get_mod'][0][0]->get_mod(array('mod' => 'adminstration','mgr' => 'adminstration','choice' => 'reminderShow'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d55231b3a6453978727e7b2c2ff8f1b3#1}';}?>

            </div>
             <div class="cont_hdr fltlft">
                <div class="cont_hdr_lft fltlft"></div>
                <div class="cont_hdr_mdl fltlft">Quick actions</div>
                <div class="cont_hdr_rht fltlft"></div>
                <div class="clear"></div>

                <div class="latest">
                    <div class="mrgn_lft">
                        <p class="lnk"><a style="cursor:pointer;" title="Add Employee" onclick="addEmployee();";>Add a New Employee</a></p>
                        <p class="lnk"><a href="http://localhost/simplehrm/index.php/adminstration/benefitManagement/" title="Manage Benifits">Manage Benefits</a></p>
                        <p class="lnk"><a href="http://localhost/simplehrm/index.php/leave/leaveRequest/" title="Manage Leaves">Manage Leaves</a></p>
                    </div>
                </div>


            </div>

           </div>

         <div class="clrbth"></div>

    </div>
    <div class="cont_bg_btm"></div>
    <center><div><font color=#707070 size=-2>Last Login: On <?php echo ((is_array($_tmp=$_SESSION['last_login'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d-%m-%Y %H:%M:%S")); ?>
 from <?php echo $_SESSION['ip']; ?>
</font></div></center>
</div>

<!-- Template: user/companyDashboard.tpl.html End --> 