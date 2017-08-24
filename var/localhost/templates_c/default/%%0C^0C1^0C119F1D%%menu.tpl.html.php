<?php /* Smarty version 2.6.7, created on 2017-08-24 10:54:46
         compiled from common/menu.tpl.html */ ?>

<!-- Template: common/menu.tpl.html Start 24/08/2017 10:54:46 --> 
 <div style="margin-top:27px;">
    <ul class="menu" id="menu">
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Dashboard</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php//companyDashboard">Dashboard</a></li></ul>
           </li>
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Employee</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php/employee/employeeList">Employees</a></li></ul>
           </li>
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Leave</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php/leave/leaveTypes">Leave Type</a></li><li><a href="http://localhost/simplehrm/index.php/leave/leaveRequest">LeaveRequest</a></li></ul>
           </li>
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Tasks</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php/tasks/taskdetails">Task Details</a></li></ul>
           </li>
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Reports</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php/report/ageProfile">Age profile</a></li><li><a href="http://localhost/simplehrm/index.php/report/companyProperties">Company properties</a></li><li><a href="http://localhost/simplehrm/index.php/report/employeeSalary">Employee salary</a></li><li><a href="http://localhost/simplehrm/index.php/report/employment_status">Employment status</a></li><li><a href="http://localhost/simplehrm/index.php/report/genderProfile">Gender profile</a></li><li><a href="http://localhost/simplehrm/index.php/report/employeeJoinings">Joining dates</a></li><li><a href="http://localhost/simplehrm/index.php/report/leaveSummery">Leave summary</a></li><li><a href="http://localhost/simplehrm/index.php/report/phoneNumbers">Phone numbers</a></li><li><a href="http://localhost/simplehrm/index.php/report/upcomingBirthdays">Upcoming birthdays</a></li></ul>
           </li>
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Admin</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php/adminstration/benefitManagement">Benefits</a></li><li><a href="http://localhost/simplehrm/index.php/adminstration/companyproperty">Company Properties</a></li><li><a href="http://localhost/simplehrm/index.php/adminstration/notifications">Notifications</a></li><li><a href="http://localhost/simplehrm/index.php/adminstration/reminders">Reminders</a></li></ul>
           </li>
    <li class="openul">
                    <div class="fltlft lft_prt"></div>
                    <div class="fltlft mdl_prt"><a class="menulink" href="javascript:void(0);">Settings</a></div>
                    <div class="fltlft rht_prt"></div><ul><li><a href="http://localhost/simplehrm/index.php/setting/companyInfo">Company Information</a></li><li><a href="http://localhost/simplehrm/index.php/setting/listing">Configuration Settings</a></li><li><a href="http://localhost/simplehrm/index.php/setting/departments">Department</a></li><li><a href="http://localhost/simplehrm/index.php/setting/divisions">Division</a></li><li><a href="http://localhost/simplehrm/index.php/setting/hrForms">HR Forms</a></li><li><a href="http://localhost/simplehrm/index.php/setting/jobtitles">Job titles</a></li><li><a href="http://localhost/simplehrm/index.php/setting/modulelist">Modules</a></li><li><a href="http://localhost/simplehrm/index.php/setting/rolelist">Roles</a></li><li><a href="http://localhost/simplehrm/index.php/setting/team">Team</a></li><li><a href="http://localhost/simplehrm/index.php/setting/userlist">Users</a></li></ul>
           </li></ul>
     <div class="clrbth"></div>
    </div>
   <div class="clrbth"></div>
  <?php echo '
  <script type="text/javascript">
   $(document).ready(function(){
	$(\'ul#menu li.openul\').hover(function(){
		//$(this).find(\'ul\').show();
		jQuery(this).find(\'> ul\').stop(true, true).slideDown(300).css(\'width\',\'150px\');

	 },function(){
		$(this).find(\'ul\').slideUp(300);
	 });
   });
   </script>
  '; ?>

  
<!-- Template: common/menu.tpl.html End --> 