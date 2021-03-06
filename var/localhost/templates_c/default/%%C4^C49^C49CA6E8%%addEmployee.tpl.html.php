<?php /* Smarty version 2.6.7, created on 2017-08-24 10:53:33
         compiled from employee/addEmployee.tpl.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'employee/addEmployee.tpl.html', 88, false),array('function', 'html_options', 'employee/addEmployee.tpl.html', 128, false),)), $this); ?>

<!-- Template: employee/addEmployee.tpl.html Start 24/08/2017 10:53:33 --> 
 <?php $this->assign('gender', $this->_tpl_vars['util']->get_values_from_config('GENDER')); ?>
<?php $this->assign('emp_sts', $this->_tpl_vars['sm']['emp_sts']); ?>
<?php $this->assign('currency', $this->_tpl_vars['util']->get_values_from_config('CURRENCY')); ?>
<?php $this->assign('pay_frequency', $this->_tpl_vars['util']->get_values_from_config('PAY_FREQUENCY')); ?>
<link rel="stylesheet" type="text/css" href="http://localhost/simplehrm/templates/css_theme/scroll.css"/>
<input type="hidden" name="step" id="step" value="1">
<!--  ******************************** PERSONAL INFO ***********************************  -->

<div style="width:580px;">
    <div class="modal_heading">
        <div class="lft fltlft"></div>
        <div class="mdl fltlft" style="width:508px;">
            Add Employee
        </div>
        <div class="rht fltlft"></div>
        <div class="clear"></div>
    </div>
    <div class="modal_body" style="padding:0px;">








	<div id="wizard">
<ul id="status">
                <li class="active"><strong>1. Personal details</strong></li>
                <li><strong>2. Contact details</strong></li>
                <li><strong>3. Job</strong></li>
             </ul>
<div class="items">
   <div class="page">
        <h2>
		<font color=#707070><strong>Step 1: </strong> Personal Details</font>
		<em>Please enter employee personal information: </em>
	</h2>
	<form id="personal_info" name="personal_info" method="post" action="javascript:void(0);">
		<table>
			<tr>
				<td>
					<b>First name: </b>
				</td>
				<td>
					<input type="text" name="employee[firstname]" value="" id="firstname" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Middle name: </b>
				</td>
				<td>
					<input type="text" name="employee[middlename]" value="" id="middlename" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Last name: </b>
				</td>
				<td>
					<input type="text" name="employee[lastname]" value="" id="lastname" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Date of birth: </b>
				</td>
				<td>
					<input type="text" name="dob" value="" id="dob" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Nationality: </b>
				</td>
				<td>
					<input type="text" name="employee[nationality]" value="" id="nationality" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Gender: </b>
				</td>
				<td>
					<?php echo smarty_function_html_radios(array('name' => "employee[gender]",'options' => $this->_tpl_vars['gender'],'selected' => 'M','separator' => ""), $this);?>

				</td>
			</tr>
			<tr>
				<td>
					<b>SSN No.: </b>
				</td>
				<td>
					<input type="text" name="employee[ssn_no]" value="" id="ssn_no" class="text"/>
				</td>
			</tr>
		</table>
		<ul class="clearfix">
			<li><button type="button" class="next right login_btn">Proceed &raquo;</button></li>
		</ul>
	</form>
   </div><!--step1-->
<!--   ********************************* EMERGENCY CONTACT ********************************  -->
   <div class="page">
   	<h2>
		<strong>Step 2: Contact details</strong>
		<em>Please enter employee contact information: </em>
	</h2>
	<form id="emergency_contact" name="emergency_contact" method="post" action="javascript:void(0);">
		<table>
			<tr>
				<td>
					<b>Address: </b>
				</td>
				<td>	
                    <textarea name="employee[address]" id="address" class="text" rows="5"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<b>Country: </b>
				</td>
				<td>
					<select name="employee[country]" onchange="showStateCity(this,'state','city','1');" id="country">
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['country'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>State: </b>
				</td>
				<td>
					<select name="employee[state]" id="state" onchange="showStateCity(this,'city','','2');" >
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['state'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>City: </b>
				</td>
				<td>
					<select name="employee[city]" id="city" onchange="putCityValue(this);">
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['city'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Work phone: </b>
				</td>
				<td>
					<input type="text" name="employee[work_phone]" value="" id="work_phone" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Mobile phone: </b>
				</td>
				<td>
					<input type="text" name="employee[mobile_phone]" value="" id="mobile_phone" class="text"/>
				</td>
			</tr>
			<tr>
				<td>
					<b>Work e-mail: </b>
				</td>
				<td>
					<input type="text" name="employee[work_email]" value="" id="work_email" class="text" onblur="return checkEmail();"/>
					<label class="error" generated="true" for="work_email"></label>
					<span id="msg_work_email" class="error"></span>

				</td>
			</tr>
			<tr>
				<td>
					<b>Other e-mail: </b>
				</td>
				<td>
					<input type="text" name="employee[other_email]" value="" id="other_email" class="text"/>
				</td>
			</tr>
		</table>
		<ul>
		    <li class="clearfix">
			<button type="button" class="prev login_btn" style="float:left">&laquo; Back</button>
			<button type="button" class="next right login_btn">Proceed &raquo;</button>
		    </li>
		</ul>
	</form>
   </div><!--step2-->
<!--   ************************************ JOB **************************************  -->
   <div class="page">
   	<h2>
		<strong>Step 3: Job details</strong>
		<em>Please enter employee job details: </em>
	</h2>
	<form id="job_info" name="job_info" method="post" action="javascript:void(0);">
		<table>
			<tr>
				<td>
					<b>Division: </b>
				</td>
				<td>
					<select name="employee[division]" id="division" onchange="showCascade(this,'department','team','job_title','1');" >
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['division'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Department: </b>
				</td>
				<td>
					<select name="employee[department]" onchange="showCascade(this,'team','job_title','','2');" id="department">
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['department'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Team: </b>
				</td>
				<td>
					<select name="employee[team]" onchange="showCascade(this,'job_title','','','3');" id="team">
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['team'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Job title: </b>
				</td>
				<td>
					<select name="employee[job_title]" id="job_title" >
						<option value="">-- Select --</option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['sm']['job_title'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Employment status: </b>
				</td>
				<td>
					<select name="employee[emp_status]" id="emp_status" >
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['emp_sts'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Date of joining: </b>
				</td>
				<td>
					<input type="text" name="joined_date" value="" id="joined_date" class="text" onchange="rem_msg();">
				</td>
			</tr>
			<tr>
				<td>
					<b>Salary: </b>
				</td>
				<td>
					<input type="text" name="employee[salary]" value="" id="salary" class="text">&emsp;
					<select name="employee[currency]" id="currency" style="width:32%;">
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['currency'],'selected' => ''), $this);?>

					</select>
					<label class="error" generated="true" for="salary"></label>
				</td>
			</tr>
			<tr>
				<td>
					<b>Pay frequency: </b>
				</td>
				<td>
					<select name="employee[pay_frequency]" id="pay_frequency" style="width:32%;">
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['pay_frequency'],'selected' => ''), $this);?>

					</select>
				</td>
			</tr>
		</table>
		<ul>
		   <li class="clearfix">
			<button type="button" class="prev login_btn" style="float:left">&laquo; Back</button>
			<button type="button" class="next right login_btn">Save &raquo;</button>
		   </li>
		</ul>
	</form>
   </div><!--step3-->
 </div>



</div>

	</div>
</div>

<?php echo '
<script type="text/javascript">
forminfo("#personal_info,#emergency_contact,#job_info");
$(document).ready(function(){
	$(\'#dob\').datepicker({dateFormat:\'dd-mm-yy\',changeMonth:true,changeYear:true,yearRange:"1911:2011" });
	$(\'#joined_date\').datepicker({dateFormat:\'dd-mm-yy\',changeMonth:true,changeYear:true,yearRange:"-100:+40" });	
 });
/* for scrollig style */
$(function() {
	var root = $("#wizard").scrollable();

	// some variables that we need
	var api = root.scrollable();
	
	// validation logic is done inside the onBeforeSeek callback
	api.onBeforeSeek(function(event, i) {
		// we are going 1 step backwards so no need for validation
		if (api.getIndex() < i) {
			/* Start of validation */
			var step=parseInt($.trim($("#step").val()));
			if(step == 1){
				var res = personalInfo();
				if(res){
					$("#step").val(2);
				 }else{
					return false;
				 }
			 }else if(step == 2){
				var res = emergencyContact();
				if(res){
					var chk=checkEmail();
					if(chk){
						$("#step").val(3);
					 }else{
						return false;
					 }
				 }else{
					return false;
				 }
			 }else if(step == 3){
				var res = jobInfo();
				if(res){
					cShowActivity(\'2\');
					var data1=$("#personal_info").serialize();
					var data2=$("#emergency_contact").serialize();
					var data3=$("#job_info").serialize();
					var url="http://localhost/simplehrm/index.php/employee/insertEmployee?"+data1+"&"+data2+"&"+data3;
					$.post(url,{ce:0 },function (res){
						var flg="';  echo $this->_tpl_vars['sm']['flg'];  echo '";
						if(flg!=\'dash\'){
							var url="http://localhost/simplehrm/index.php/page-employee-choice-employeeList-ce-0-chk-1-msg-"+res;
							var httpRequest = new XMLHttpRequest();
							httpRequest.open(\'POST\', url, false);
							httpRequest.send(); 
							if (httpRequest.status == 200) {
								var z=httpRequest.responseText;
								$("#employee_employeeList").html(z);
								$.fancybox.close();
								cHideActivity();
							 }
						 }else{
							location.reload(true);
							callmsg(res);
						 }	
					 });
				 }else
					return false;
			 }
			/* End */
		 }else{
			step=parseInt($.trim($("#step").val()));
			$("#step").val(step-1);
		 }
		// update status bar
		$("#status li").removeClass("active").eq(i).addClass("active");

	 });
	// if tab is pressed on the next button seek to next page
	root.find("button.next").keydown(function(e) {
		if (e.keyCode == 9) {
			return false;
		 }
	 });
 });
/* Scrolling style End */ 
function showStateCity(obj,id1,id2,lvl){
	var id = obj.value;
	var url = "http://localhost/simplehrm/index.php/";
	$.post(url,{page:"employee",choice:"showStateCity",ce:0,id:id,flg:id1 },function(res){
		$(\'#\'+id1).html(res);
		if(lvl==1){
			$(\'#\'+id2).html(\'<option value="">-- Select --</option>\');
		 }
	 });
	var x=obj.selectedIndex;
	if(x!=0){
		obj.options[x].value=obj.options[x].text;
	 }
 }
function putCityValue(obj){
	var x=obj.selectedIndex;
	if(x!=0){
		obj.options[x].value=obj.options[x].text;
	 }
 }
function showCascade(obj,id1,id2,id3,lvl){
	var id = obj.value;
	var url = "http://localhost/simplehrm/index.php/";
	$.post(url,{page:"employee",choice:"showDepartmentTeamJob",ce:0,id:id,flg:id1 },function(res){
		$(\'#\'+id1).html(res);
		if(lvl==1){
			$(\'#\'+id2).html(\'<option value="">-- Select --</option>\');
			$(\'#\'+id3).html(\'<option value="">-- Select --</option>\');
		 }else if(lvl==2){
			$(\'#\'+id3).html(\'<option value="">-- Select --</option>\');
		 }
	 });
 }
function checkEmail(){
	var emp_email=$.trim($(\'#work_email\').val());
	if(emp_email==\'\'){
		$("#msg_work_email").html(\'\');
		return 1;	
	 }
	var url="http://localhost/simplehrm/index.php/employee/checkEmail/ce-0-emp_email-"+emp_email;
	var httpRequest = new XMLHttpRequest();
	httpRequest.open(\'POST\', url, false);
	httpRequest.send(); 
	if (httpRequest.status == 200) {
		var z=httpRequest.responseText;
		if(check_JSsession(z,0)) {
			if(z!=\'\'){
				if(z==0){
					$("#msg_work_email").html(\'\');
					return 1;
				 }else{
					$("#msg_work_email").html(\'This email id already exists.\');
					return 0;
				 }
			 }
		 }
	 }	
 }
function rem_msg(){
	if ( $("#joined_date").val() != \'\' ) {
		$(\'#job_info\').find(\'label[for="joined_date"]\').html(\'\');
	 }
 }
function personalInfo(){		
	var validator_pers_info=$("#personal_info").validate({
		rules: {
			"employee[firstname]": {
				required:true
			 }
		 },
		messages: {
			"employee[firstname]":{
				required:\'This field is required.\'
			 }
		 }
	 });
	return validator_pers_info.form();
 }
function emergencyContact(){
	validator_emer_cont=$("#emergency_contact").validate({
		rules: {
			"employee[work_email]": {
				required:true,
				email:true
			 },
			"employee[other_email]": {
				email:true
			 }
		 },
		messages: {
			"employee[work_email]":{
				required:\'This field is required.\',
				email:\'Please enter a valid email address.\'
			 },
			"employee[other_email]":{
				email:\'Please enter a valid email address.\'
			 }
		 }
	 });
	return validator_emer_cont.form();
 }
function jobInfo(){
	validator_job_info=$("#job_info").validate({
		rules: {
			"employee[division]": {
				required:true
			 },
			"employee[department]": {
				required:true
			 },
			"employee[emp_status]": {
				required:true
			 },
			"joined_date": {
				required:true
			 },
			"employee[salary]": {
				required:true,
				number:true
			 }
		 },
		messages: {
			"employee[division]":{
				required:\'&emsp;This field is required.\'
			 },
			"employee[department]":{
				required:\'&emsp;This field is required.\'
			 },
			"employee[emp_status]": {
				required:\'This field is required.\'
			 },
			"joined_date": {
				required:\'&nbsp;This field is required.\'
			 },
			"employee[salary]": {
				required:\'<br>This field is required.\',
				number:\'<br>Please give a valid salary\'
			 }
		 }
	 });
	return validator_job_info.form();
 }
</script>
<style type="text/css">
	select,option { text-transform : capitalize ; }
	span.error	{
		color:#FF0000;
		font-size:12px;
	 }
</style>
'; ?>


<!-- Template: employee/addEmployee.tpl.html End --> 