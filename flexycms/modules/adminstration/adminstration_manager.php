<?php
/**
 * Class   : adminstration_manager
 * Purpose : All administration coding done here. 
 */
class adminstration_manager extends mod_manager {
#######################################################################################################
### Function Name : adminstration_manager	  						    ###
### Description   : This is a constructor 							    ###					 
### Input         : Reference of smarty,input and output parameters 	  			    ###
### Output	  : Initiates mod manager and initialize object and business class for user manager ###
#######################################################################################################
	function adminstration_manager (& $smarty, & $_output, & $_input) {
		if($_REQUEST['ce']!='0'){
			if(!(($_REQUEST['choice'] =='cronJobNotification') || ($_REQUEST['choice'] =='cronJobReminder'))){
	    			check_session();
	    		}
	    	}else{
			//for autocomplete and fancybox
	    		if(!$_SESSION['id_user'] && $_REQUEST['for']=='auto'){
				exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>|abc::".getmessage('COM_NO_SESSION'));
			}elseif(!$_SESSION['id_user'] && $_REQUEST['for']=='norauto'){
	    			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>|".getmessage('COM_NO_SESSION'));
	    		}elseif(!$_SESSION['id_user']){
	    			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."Please <a href='javascript:void(0);' onclick=check_JSsession('nosession',0); style='text-decoration : underline;'>click</a> here to log in again</span>");
	    		}
	    	}
		$this->mod_manager($smarty, $_output, $_input, 'adminstration');
		$this->obj_adminstration= new adminstration;
		$this->adminstration_bl = new adminstration_bl;
 	}
#########################################################################################
### Function Name : get_module_name(Predefined Function)			      ###
#########################################################################################
	function get_module_name() { 
		return 'adminstration';
	}
#########################################################################################
### Function Name : get_manager_name(Predefined Function) 			      ###
#########################################################################################
	function get_manager_name() {
		return 'adminstration';
	}
#########################################################################################
### Function Name : default(Predefined Function) 		  		      ###
### Description   : Handle default request(if no choice specified)                    ###
#########################################################################################
	function _default() {
		return true;
	}
#########################################################################################
### Function Name : manager_error_handler					      ###
### Description   : Function to handle error when choice not found                    ###
### Input         : No input 						   	      ###
### Ouput         : Error handling template.		         		      ###
#########################################################################################
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			//Put your own error handling code here
			$this->_output['tpl'] ='default/error_handler';
		}
	}
	


##########################################################################################
### Function Name : _reminders		   					       ###
### Description   : Function to show listing of reminders of company. 		       ###
### Input         : No input 							       ###
### Ouput 	  : Editable reminders or reminderListing template accordingly         ###
##########################################################################################
	function _reminders() {
		$sql = get_search_sql("companyReminder");
		$uri = 'index.php/adminstration/reminders';
		$this->_output['type']= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Reminder List";
		$this->_output['field']= array("reminder"=>array("Reminder", 1), "reminder_date"=>array("Date & Time",1,"format"=>"date_format:'%d-%m-%Y'"),"recurrence_status"=>array("Frequency", 1));
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show']= $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql']= $sql;
		$this->_output['uri']= $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_reminder";
		$this->_output['duration'] = $GLOBALS['conf']['DURATION'];
		if($_SESSION['reminder_qs']!=''){
			$this->_input['qstart']=$_SESSION['reminder_qs'];
			$_SESSION['reminder_qs']='';
		}
		if($this->_input['chk']){
			$this->adminstration_bl->page_listing($this,"adminstration/reminderListing"); 
		}else{			
			$this->adminstration_bl->page_listing($this,"adminstration/reminders"); // Pass the template name as a 3rd optional parameter.
		}
	}
	
##########################################################################################
### Function Name : _addEditReminder						       ###
### Description   : Function to show editable General Configuration Options of	       ###
###		     company .							       ###
### Input         : No input 							       ###
### Ouput	  : Editable General Configuration Options template	               ###
##########################################################################################
	function _addEditReminder(){
		global $link;
		if($this->_input['ch']=='edit'){
			$reminder_sql = get_search_sql("companyReminder","id_reminder=".$this->_input['id_reminder']);
		
			$reminder_res = getsingleindexrow($reminder_sql);
			$temp_dt=explode(" ",$reminder_res['reminder_date']);
			$temp_tm=explode(":",$temp_dt[1]);
			if($temp_tm[0]=='00'){
				$temp_tm[0]=12;
				$temp_tm[2]='AM';
			}else{
				$temp_tm[2]='PM';
			}
			$reminder_res['reminder_date']=convertodate($temp_dt[0],"dd-mm-yyyy","yyyy-mm-dd");
			$reminder_res['reminder_time']=$temp_tm[0].":".$temp_tm[1]." ".$temp_tm[2];
			$this->_output['reminder']    = $reminder_res;
			$this->_output['qstart']    = $this->_input['qstart'];
		}
 		$this->_output['duration'] = $GLOBALS['conf']['DURATION'];
		$this->_output['tpl']= 'adminstration/addReminder';
	}
		
##########################################################################################
### Function Name : _insertUpdateReminder					       ###
### Description   : Function to add or update reminders of company		       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _reminders() function		       		       ###
##########################################################################################
	function _insertUpdateReminder(){
		$arr=$this->_input['reminder'];
		$reminder_time = split(' ',$this->_input['reminder_time']);
		$rmin = split(':',$reminder_time['0']);
		if($reminder_time['1'] == 'PM'){
			if($rmin['0']!=12){
				$rtime = 12+$rmin['0'].":".$rmin['1'];
			}else{
				$rtime ="12:".$rmin['1'];
			}	
		}else if($reminder_time['1'] == 'AM'){
			if($rmin['0']==12){
				$rtime ="00:".$rmin['1'];
			}else{
				$rtime =$rmin['0'].":".$rmin['1'];
			}	
		}
		$d=convertodate($this->_input['reminder']['reminder_date'],"dd-mm-yyyy","yyyy-mm-dd");
		$arr['reminder_date'] = $d." ".$rtime;
		$arr['id_company']=$_SESSION['id_user'];
		if(!$this->_input['tempid']){
			$this->obj_adminstration->insert($arr,"companyReminder",1);
			$_SESSION['raise_message']['global'] = getmessage('COM_INS_SUCC');
		}else{
			$_SESSION['reminder_qs']=$this->_input['qstart'];
			$this->obj_adminstration->updateall("companyReminder",$arr,"id_reminder=".$this->_input['tempid']);
			$_SESSION['raise_message']['global'] = getmessage('COM_UPD_SUCC');
		}
			redirect(LBL_SITE_URL.'index.php/adminstration/reminders');
	}
##########################################################################################
### Function Name : _deleteReminder						       ###
### Description   : Function to delete reminders of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _reminders() function		       		       ###
##########################################################################################
	function _deleteReminder(){
		$this->obj_adminstration->delete($this->_input['id'],"id_reminder","","companyReminder");
		if(($this->_input['cur']==1) && $this->_input['qstart']){
			$this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
		}
		$msg=getmessage("COM_DEL_SUCC");
		$this->_input['choice']="reminders";
		print "<script>callmsg('".$msg."')</script>";
		$this->_reminders();
	}
##########################################################################################
### Function Name : _leaveTypes		   					       ###
### Description   : Function to show listing of leaveTypes of company. 		       ###
### Input         : No input 							       ###
### Ouput 	  : Editable leaveType  template       		       	 	       ###
##########################################################################################
	function _leaveTypes(){
		$uri="index.php/page-adminstration-choice-leaveTypes";
		$cond="id_company=".$_SESSION['id_company'];
		if($this->_input['leave_type_name']!=''){
			$cond.=" AND leave_type LIKE '%".$this->_input['leave_type_name']."%' ";
			$uri.="-leave_type_name-".$this->_input['leave_type_name'];
		}
		$sql=get_search_sql("companyLeaveType",$cond);
		$_REQUEST['choice']='leaveTypes';
		$this->_output['sql'] = $sql;
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['ajax']= "ajax";		
		$this->_output['uri'] = $uri;
		$this->_output['type'] = "box";
		$this->_output['pg_header'] = "Leave Types List";
		$this->_output['sort_order'] = "DESC";
		$this->_output['sort_by'] = "id_leave_type";
		$this->_output['show']=$GLOBALS['conf']['PAGINATE']['show_page'];	
		$this->_output['field'] = array("name"=>array("Name",1));
		$this->_output['emp']=$this->commonEmpCount('leave_type','employeeLeaveRequest','leave_type');
		
		if($_SESSION['leave_qs']!=''){
			$this->_input['qstart']=$_SESSION['leave_qs'];
			$_SESSION['leave_qs']='';
		}
		if($this->_input['chk']){
			$this->adminstration_bl->page_listing($this,'adminstration/leaveType');
		}else{
			$this->adminstration_bl->page_listing($this,'adminstration/leaveTypeSearch');
		}
	}
##########################################################################################
### Function Name : addLeaveTypes						       ###
### Description   : Function to add leave Types of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _leaveTypes() function		       		       ###
##########################################################################################
	function _addLeaveTypes(){
		$arr['leave_type']=$this->_input['leave_type'];
		$arr['id_company']=$_SESSION['id_user'];
		$this->obj_adminstration->insert($arr,"companyLeaveType");
		$this->_output['qstart'] =$this->_input['qstart'];
		$_SESSION['raise_message']['global'] = getmessage('COM_INS_SUCC');
		redirect(LBL_SITE_URL.'index.php/adminstration/leaveTypes');
	}

##########################################################################################
### Function Name : _updateLeave						       ###
### Description   : Function to update leave Types of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _leaveTypes() function		       		       ###
##########################################################################################
	function _updateLeave(){
		$arr['leave_type']=$this->_input['leave_type'];
		$this->obj_adminstration->updateall("companyLeaveType",$arr,"id_leave_type=".$this->_input['temp_id']);
		$_SESSION['raise_message']['global'] = getmessage('COM_UPD_SUCC');
		$_SESSION['leave_qs']=$this->_input['qstart'];
		redirect(LBL_SITE_URL.'index.php/adminstration/leaveTypes');
	}
##########################################################################################
### Function Name : _deleteLeave						       ###
### Description   : Function to delete leave Types of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _leaveTypes() function		       		       ###
##########################################################################################
	function _deleteLeave(){
		$r=$this->obj_adminstration->delete($this->_input['id'],"id_leave_type","","companyLeaveType");
		if($r){
			if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
	                       $this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
	                }
			$msg=getmessage("COM_DEL_SUCC");
			print "<script>callmsg('".$msg."')</script>";
			$this->_leaveTypes();
		}
	}
######################################################################################
### Function Name : commonEmpCount                                                 ###
### Description   : This function returns the nunber of employee associated with   ###
###                a particular division or department or team or jobtitle likewise###
### Input         : id table ,tableneme,groupby id                                 ###
### Ouput         : returns the result result in an array format                   ###
######################################################################################
	function commonEmpCount($id,$tbl,$group_by){
		$sql_emp_cnt = "SELECT id_employee,".$id.",COUNT(*) AS cnt FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX.$tbl." E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE IF(terminate_date!='',terminate_date > NOW(),1) GROUP BY ".$group_by;
		return getindexrows($sql_emp_cnt,$id,'cnt');
	}
##########################################################################################
### Function Name : _benefitManagement		   				       ###
### Description   : Function to show listing of benefits of company		       ###
### Input         : No input 							       ###
### Ouput 	  : Editable benefitManagement template       		   	       ###
##########################################################################################
	function _benefitManagement(){
		$uri="index.php/page-adminstration-choice-benefitManagement";
		$cond="id_company=".$_SESSION['id_company'];
		if($this->_input['benefit_name']!=''){
			$cond.=" AND benefit_name LIKE '%".$this->_input['benefit_name']."%' ";
			$uri.="-benefit_name-".$this->_input['benefit_name'];
		}
		$sql = get_search_sql("companyBenefits",$cond);
		$_REQUEST['choice']='benefitManagement';
		$this->_output['sql'] = $sql;
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['ajax']= "ajax";		
		$this->_output['uri'] = $uri;
		$this->_output['type'] = "box";
		$this->_output['pg_header'] = "Benefit List";
		$this->_output['sort_order'] = "DESC";
		$this->_output['sort_by'] = "id_benefits";
		$this->_output['show']=$GLOBALS['conf']['PAGINATE']['show_page'];	
		$this->_output['field'] = array("name"=>array("Name",1));
		$this->_output['cnt_res']=$this->commonEmpCount('id_benefits','employeeBenefits','id_benefits');
		
		if($_SESSION['benefit_qs']!=''){
			$this->_input['qstart']=$_SESSION['benefit_qs'];
			$_SESSION['benefit_qs']='';
		}
		if($this->_input['chk']){
			$this->adminstration_bl->page_listing($this,'adminstration/benefitManagement');
		}else{
			$this->adminstration_bl->page_listing($this,'adminstration/benefitManagementSearch');
		}
	}
##########################################################################################
### Function Name : _addBenefit						               ###
### Description   : Function to add benefits of company				       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _benefitManagement() function		       	       ###
##########################################################################################
	function _addBenefit(){
		$arr['benefit_name']=$this->_input['benefit_name'];
		$arr['id_company']=$_SESSION['id_user'];
		$this->obj_adminstration->insert($arr,"companyBenefits");
		//$this->_output['leave_type'] =$this->_input['leave_type'];
		$this->_output['qstart'] =$this->_input['qstart'];
		$_SESSION['raise_message']['global'] = getmessage('COM_INS_SUCC');
		redirect(LBL_SITE_URL.'index.php/adminstration/benefitManagement');
	}
##########################################################################################
### Function Name : _updateBenefit						       ###
### Description   : Function to update benefits Types of company		       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _benefitManagement() function		       	       ###
##########################################################################################
	function _updateBenefit(){
		$arr['benefit_name']=$this->_input['benefit_name'];
		$this->obj_adminstration->updateall("companyBenefits",$arr,"id_benefits=".$this->_input['temp_id1']);
		$_SESSION['raise_message']['global'] = getmessage('COM_UPD_SUCC');
		$_SESSION['benefit_qs']=$this->_input['qstart'];
		redirect(LBL_SITE_URL.'index.php/adminstration/benefitManagement');
	}
##########################################################################################
### Function Name : _deleteBenefit						       ###
### Description   : Function to delete benefits of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _benefitManagement() function		       	       ###
##########################################################################################
	function _deleteBenefit(){
		$r=$this->obj_adminstration->delete($this->_input['id'],"id_benefits","","companyBenefits");
		if($r){
			if(($this->_input['cnt']==1) && ($this->_input['qstart'])){
		               $this->_input['qstart']=$this->_input['qstart']-$GLOBALS['conf']['PAGINATE']['rec_per_page'];
		        }
		$msg=getmessage("COM_DEL_SUCC");
		print "<script>callmsg('".$msg."')</script>";
		$this->_benefitManagement();
		}
	}

##########################################################################################
### Function Name : _notifications		   				       ###
### Description   : Function to show listing of notifications of company	       ###
### Input         : No input 							       ###
### Ouput 	  : Editable notifications template       		   	       ###
##########################################################################################
	function _notifications(){
		$sql='CALL get_search_sql("'.TABLE_PREFIX.'companyNotification","")';
		$res=getrows($sql,$err);
		
		$this->_output['duration'] = $GLOBALS['conf']['DURATION_NOTIFICATION'];
		$this->_output['sel_dura'] =$res[0]['notification_status'];
		$this->_output['res'] =$res[0];
		if($res[0]['id_employee']){
			$emp_sql='CALL get_search_sql("'.TABLE_PREFIX.'employee","id_employee='.$res[0]["id_employee"].'")';
			$emp_res=getrows($emp_sql,$err);
			$this->_output['name'] =$emp_res[0]['firstname']." ".$emp_res[0]['middlename']." ".$emp_res[0]['lastname'];
		}
		$this->_output['tpl'] ='adminstration/notifications';
	}
##########################################################################################
### Function Name : _updateNotification						       ###
### Description   : Function to update Notification Types of company		       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _notifications() function		       	       ###
##########################################################################################
	function _updateNotification(){
		$arr=array('birthday'=>'1','notification_status'=>'1','contract_end'=>'1','emp_add'=>'1','emp_modify'=>'1','emp_remove'=>'1','id_employee'=>'0');
		$arr1=$this->_input['notification'];
		foreach ($arr as $k => $v){
			if(isset($arr1[$k])){
				if($k=="notification_status" || $k=="id_employee"){
					$arr[$k]=$arr1[$k];
				}else{
					$arr[$k]=1;
				}	
			}else{
				$arr[$k]=0;	
			}
		}
		$this->obj_adminstration->updateall("companyNotification",$arr,"id_notification=".$this->_input['notify_id']);
		$_SESSION['raise_message']['global'] = getmessage('COM_UPD_SUCC');
		redirect(LBL_SITE_URL.'index.php/adminstration/notifications');
	}
##########################################################################################
### Function Name : _insertNotification						       ###
### Description   : Function to insert Notification   				       ###
### Input         : Notification information					       ###
### Ouput	  : Redirect to _notifications() function		       	       ###
##########################################################################################
	function _insertNotification(){
		$notify=$this->_input['notification'];
		$notify['id_company']=$_SESSION['id_company'];
		$this->obj_adminstration->insert($notify,"companyNotification",1);
		$_SESSION['raise_message']['global'] = getmessage('COM_INS_SUCC');
		redirect(LBL_SITE_URL.'index.php/adminstration/notifications');
	}
##########################################################################################
### Function Name : _userAutoComplete						       ###
### Description   : Function show employeename with photo as facebook in notification  ###
### Input         : No input 					 		       ###
### Ouput	  : autoList template 				         	       ###
##########################################################################################
	function _userAutoComplete(){
		if(!$_SESSION['id_user']){
			exit;
		}
		global $link;
		$sql="SELECT id_employee,name,avatar,gender FROM ( SELECT *,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name FROM ".TABLE_PREFIX."employee WHERE id_company=".$_SESSION['id_user']." ) AS temp_emp WHERE name LIKE '%".$this->_input['q']."%' ORDER BY temp_emp.name ";
		
		$data=getautorows($sql);
		ob_clean();
		$this->_output['data']=isset($data)?$data:'';
		$this->_output['flag']=2;
		$this->_output['tpl']='employee/autoList';
	}
##########################################################################################
### Function Name : _reminderIcs						       ###
### Description   : Function to download a file with ics format of notification        ###
### Input         : No input 							       ###
### Ouput	  : downloaded file            				       	       ###
##########################################################################################
	function _reminderIcs(){
		$conf = $GLOBALS['conf']['DURATION'];
		$sql='CALL get_search_sql("'.TABLE_PREFIX.'companyReminder","status != 2")';
		$arr=getrows($sql,$err);
		$filename = APP_ROOT.'reports/HRM_Reminder.ics';
		$handle = fopen($filename, 'w+');
		if (!$handle) {
			echo "Cannot open file ($filename)";
			exit;
		}
		$ics  = "BEGIN:VCALENDAR\n";
		$ics .= "VERSION:2.0\n";
		$ics .= "CALSCALE:GREGORIAN\n";
		$ics .= "METHOD:PUBLISH\n";
		for($i=0;$i<count($arr);$i++){
			$desc=$arr[$i]['reminder'];
			$rrule = strtoupper($conf[$arr[$i]['recurrence_status']]);
			$x=split('[- :]',$arr[$i]['reminder_date']);			
			$dt=$x[0].$x[1].$x[2];
			
			$ics .= "BEGIN:VEVENT\n";
			$ics .= "CATEGORIES:HRM\n";
			$ics .= "DTSTART:$dt\n";
			
			$ics .= "RRULE:FREQ=".$rrule."\n";
			
			$ics .= "SUMMARY:$desc\n";
			$ics .= "DESCRIPTION:$desc\n";
			$ics .= "END:VEVENT\n";
		}
		$ics .= "END:VCALENDAR";
		if (!fwrite($handle, $ics)) {
			echo "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
		$Filename = "HRM_Reminder.ics";
		header("Content-Type: text/x-vCalendar");
		header("Content-Disposition: inline; filename=$Filename");
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		print $contents;
		exit;
	}
##########################################################################################
### Function Name : _changeReminderStatus					       ###
### Description   : Function to change the reminder status                             ###
### Input         : No input 							       ###
### Ouput	  : return true				       	                       ###
##########################################################################################
	function _changeReminderStatus(){
		$this->obj_adminstration->changeStatus($this->_input['id'],$this->_input['val']);
		print 1;exit;
	}
##########################################################################################
### Function Name : _cronJobNotification					       ###
### Description   :  it will fire a mail                                               ###
### Input         : No input 							       ###
### Ouput	  : no output			                         	       ###
##########################################################################################
	function _cronJobNotification(){
		$sql_company="SELECT TT.*,E.work_email FROM (SELECT CN.*,C.email_id,C.company_name,C.logo FROM ".TABLE_PREFIX."companyNotification CN,".TABLE_PREFIX."company C WHERE CN.id_company=C.id_company) TT LEFT JOIN ".TABLE_PREFIX."employee E ON TT.id_employee=E.id_employee";
		$res_company=getrows($sql_company,$err);
		$cnt=count($res_company);
		for($i=0;$i<$cnt;$i++){
			$this->notifyCompany($res_company[$i]);
		}
	}
##########################################################################################
### Function Name : notifyCompany				        	       ###
### Description   : It notifies company by mail                                        ###
### Input         : Result set							       ###
### Ouput	  : no output			                         	       ###
##########################################################################################
	function notifyCompany($res){
		$cond_bday="";
		$cond_notifi="";
		if($res['notification_status']==1){
			$days="1";
		}elseif($res['notification_status']==2){
			$days="7";
		}else{
			$days1="1";
			$days="7";
			$cond_bday.=$this->makeSql("dob",$days1)." OR ";
			$cond_notifi=$this->makeSql("terminate_date",$days1)." OR ";
		}
		$cond_bday.=$this->makeSql("dob",$days);
		$cond_notifi=$this->makeSql("terminate_date",$days);
		
		if($res['birthday']){
			$sql_bday="SELECT E.id_employee,gender,emp_status,joined_date,work_email,work_phone,avatar,dob,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name FROM  ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee WHERE IF(terminate_date!='',terminate_date > NOW(),1) AND ".$cond_bday." AND id_company=".$res['id_company'];
			$res_bday=getrows($sql_bday,$err);
			if($res_bday){
				$this->sendMail("Birthday Notification",$res['email_id'],$res,"res_bday",$res_bday);
			}
		}
		if($res['contract_end']){
			$sql_contract="SELECT CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) name,gender,avatar,ET.* FROM ".TABLE_PREFIX."employeeTerminationContract ET,".TABLE_PREFIX."employee E WHERE ET.id_employee=E.id_employee AND E.id_company=".$res['id_company']." AND ".$cond_notifi;
			$res_contract=getrows($sql_contract,$err);
			if($res_contract){
				$this->sendMail("Contract End Notification",$res['email_id'],$res,"res_contract",$res_contract);
			}
		}
	}
##########################################################################################
### Function Name : _cronJobReminder					               ###
### Description   :  it will fire a mail                                               ###
### Input         : No input 							       ###
### Ouput	  : no output			                         	       ###
##########################################################################################
	function _cronJobReminder(){
		global $smarty;
		$sql_company="SELECT id_company,email_id FROM ".TABLE_PREFIX."company";
		if($this->_input['id_com'])
			$sql_company .= " WHERE id_company = ".$this->_input['id_com'];
		$sql_company .= " LIMIT 1";
		$res_company=getsingleindexrow($sql_company);
		
		$status=array_flip($GLOBALS['conf']['DURATION']);
		$sql="SELECT * FROM ".TABLE_PREFIX."companyReminder where status=1 AND id_company=".$res_company['id_company']." AND reminder_date <= now() AND (recurrence_status=".$status['Daily']." OR MOD(DateDiff(NOW(),reminder_date),7)=0 OR MOD(DateDiff(NOW(),reminder_date),30)=0)";
		$reminders=getrows($sql,$err);
		$smarty->assign('reminders',$reminders);
		$body=$smarty->fetch("adminstration/mail4Reminder.tpl.html");
		$subject="Reminder List";
		sendmail($res_company['email_id'],$subject,$body,$res_company['email_id']);
	}

##########################################################################################
### Function Name : makeSql					        	       ###
### Description   : It creates sql		                                       ###
### Input         : Fields, intervals in days					       ###
### Ouput	  : Returns a sql		                         	       ###
##########################################################################################
	function makeSql($fld='',$ds){
        	return " DATE_FORMAT(".$fld.",'%d %m')=DATE_FORMAT(DATE_ADD( NOW( ) , INTERVAL ".$ds." DAY ),'%d %m')";
	}
##########################################################################################
### Function Name : sendMail					        	       ###
### Description   : It sends mail to admin, selected employee(optional)                ###
### Input         : Subject, from, employees result set, variable name, result set     ###
### Ouput	  : no output			                         	       ###
##########################################################################################
	function sendMail($sub,$from,$res,$var_name="",$res_set=""){
		global $smarty;
		$smarty->assign('company',$res);
		$smarty->assign($var_name,$res_set);
		$body=$smarty->fetch("adminstration/mail4Notification.tpl.html");
		$subject=$sub;
		if($res['email_id']){	
			sendmail($res['email_id'],$subject,$body,$from);
		}
		if($res['work_email']){	
			sendmail($res['work_email'],$subject,$body,$from);
		}
	}
##########################################################################################
### Function Name : _reminderShow        					       ###
### Description   :                                                                    ###
### Input         : No input 							       ###
### Ouput	  : reminderShow template                                	       ###
##########################################################################################
	function _reminderShow(){
		global $link;
		$sql_rem="SELECT * FROM ".TABLE_PREFIX."companyReminder WHERE status=1 AND reminder_date BETWEEN CURDATE() AND ADDDATE(CURDATE(),INTERVAL 2 DAY ) ORDER BY reminder_date ASC";
		$res_rem=getrows($sql_rem,$err);

		$sql1="SELECT * FROM ".TABLE_PREFIX."companyNotification LIMIT 1";
		$res1=getsingleindexrow($sql1);

		if($res1['birthday']){
			$sql_emp="SELECT (SELECT CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) FROM ".TABLE_PREFIX."employee WHERE id_employee=e.id_employee) AS name,dob,work_email,work_phone FROM ".TABLE_PREFIX."employee e WHERE date_format(dob,'%m %d') BETWEEN date_format(CURDATE(),'%m %d') AND date_format(ADDDATE(CURDATE(),INTERVAL 2 DAY ),'%m %d')";
			$res_emp=getrows($sql_emp,$err);
		}
		$status=array_flip($GLOBALS['conf']['LEAVE_STATUS']);
		$sql_leave="SELECT (SELECT CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) FROM ".TABLE_PREFIX."employee WHERE id_employee=l.id_employee) AS name FROM ".TABLE_PREFIX."employeeLeaveRequest l WHERE leave_status=".$status['Pending'];
		$res_leave=getrows($sql_leave,$err);
		
		$this->_output["res_leave"]=$res_leave;
		$this->_output["res_rem"]=$res_rem;
		$this->_output["res_emp"]=$res_emp;
		$this->_output["tpl"]="adminstration/reminderShow";
	}
##########################################################################################
### Function Name : _autoBenefitName						       ###
### Description   : Function show benefit name in dropdown list                        ###
### Input         : No input 					 		       ###
### Ouput	  : autoList template 				         	       ###
##########################################################################################
	function _autoBenefitName(){
		global $link;
		if(!$_SESSION['id_user']){
			exit;
		}
		$sql="SELECT DISTINCT(benefit_name) FROM ".TABLE_PREFIX."companyBenefits WHERE id_company=".$_SESSION['id_company']." AND benefit_name LIKE '%".$this->_input['q']."%' ORDER BY benefit_name";
		$data=getautorows($sql,'benefit_name');
		$this->_output['data']=isset($data)?$data:'';
		$this->_output['tpl']='adminstration/autoList';
	}
##########################################################################################
### Function Name : _autoLeaveTypeName						       ###
### Description   : Function show leave_type name  in dropdown list                    ###
### Input         : No input 					 		       ###
### Ouput	  : autoList template 				         	       ###
##########################################################################################
	function _autoLeaveTypeName(){
		global $link;
		if(!$_SESSION['id_user']){
			exit;
		}
		$sql="SELECT DISTINCT(leave_type) FROM ".TABLE_PREFIX."companyLeaveType WHERE id_company=".$_SESSION['id_company']." AND leave_type LIKE '%".$this->_input['q']."%' ORDER BY leave_type";
		$data=getautorows($sql,'leave_type');
		$this->_output['data']=isset($data)?$data:'';
		$this->_output['tpl']='adminstration/autoList';
	}
	
	
	
#####################################################################################################
# Function Name : _leaveschemelist                                                                  #
# Description   : Gives list of all leaveschemelist under an adminstration				                #
#		                      	                                                                    #
# Input         : id_employee                                                                       #
# Output	    : leaveschemelist template            				                                    #
#####################################################################################################
	function _leaveSchemeList($id=''){
  		$sql_property="select * from ".TABLE_PREFIX."companyleavescheme";
  		$res=getrows($sql_property,$err);
		$this->_output['list']=$res;
		$this->_output['tpl']="adminstration/leaveSchemeList";
	}
######################################################################################################
# Function Name : _addleavescheme                                                                    #
# Description   : Gives an ui to addeavescheme under an administration                               #
#		                      	                                                                     #
# Input         : id_leave_scheme                                                                    #
# Output	    : addleavescheme template            				                                 #
######################################################################################################
	function _addleavescheme($id=""){
		if($_SESSION['id_company']){
 			$this->_output['tpl']="adminstration/addleavescheme";
		}else{
			redirect(LBL_SITE_URL);
		}
	}
	
#####################################################################################################
# Function Name : _editleavescheme                                                                  #
# Description   : Gives an ui to editleavescheme under an administration				            #
#		                      	                                                                    #
# Input         : id_leave_scheme                                                                   #
# Output	    : addleavescheme template            				                                #
#####################################################################################################

	function _editleavescheme($id=""){
		if($_SESSION['id_company']){
			$arr['id']=$this->_input['id'];
			$sql_property="select * from ".TABLE_PREFIX."companyleavescheme where id_leave_scheme=".$arr['id'];
		//$res=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyleavescheme","'."	id_leave_type=".$_SESSION['id_company'].'")',"leave_schemename","id_leave_type",$err);
		  $res=getsingleindexrow($sql_property,$err);
			$this->_output['leave_scheme']=$res;
   //print_r($this->_output['leave_scheme']);
			$this->_output['tpl']="adminstration/addleavescheme";
		}else{
			redirect(LBL_SITE_URL);
		}
	}
#####################################################################################################
# Function Name : _insertleavescheme                                                                #
# Description   : Insert leave scheme under an adminstration					                    #
#		                      	                                                            #       #
# Input         : id_employee                                                                       #
# Output	    : call to insertleavescheme function				                    #               #
#####################################################################################################
	function _insertleavescheme(){
 		$arr['Leave_schemename ']=$this->_input['leavescheme']['name'];
 		$arr['id_leave_type']=$this->_input['leavescheme']['id'];
 		$arr['leave_elgidays']=$this->_input['leavescheme']['leaveelgi'];
     	$this->obj_adminstration->insert($arr,"companyleavescheme");
        $msg=getmessage('COM_INS_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
	    $this->_leaveSchemeList($_SESSION['id_company']);

	}
	
#######################################################################################################
# Function Name : _UpdateLEaveScheme                                                                  #
# Description   : update leaveschme under an adminstration					                          #
#		                      	                                                                      #
# Input         : id_employee                                                                         #
# Output	    : call to  updateleavescheme function			                                      #
#######################################################################################################
	function _updateleavescheme()
       {
  		$arr['Leave_schemename']=$this->_input['leavescheme']['name'];
 		$arr['id_leave_type']=$this->_input['leavescheme']['id'];
 		$arr['leave_elgidays']=$this->_input['leavescheme']['leaveelgi'];
        $RES=$this->obj_adminstration->update("companyleavescheme",$arr,"id_leave_scheme=".$this->_input['leavescheme']['temp_id']);
        $msg=getmessage('COM_UPD_SUCC');
		print "<script>callmsg('".$msg."');</script>";
	    $this->_leaveSchemeList($_SESSION['id_company']);
        }
#######################################################################################################
# Function Name : _deleteleavescheme                                                                  #
# Description   : delete leave scheme under an adminstration 					                      #
#		                      	                                                                      #
# Input         : id_employee                                                                         #
# Output	    : call to delete leavescheme function				                                  #
#######################################################################################################
	function _deleteLeaveScheme(){
		if($_SESSION['id_company']){
			//$id_employee=$this->_input['id_employee'];
			echo $this->_input['id_leavescheme'];
		//	exit;
			$this->obj_adminstration->delete($this->_input['id_leavescheme'],"id_leave_scheme","","companyleavescheme");
		//	$this->obj_adminstration->delete("companyleavescheme","id_leave_scheme".$this->_input['id_leavescheme']."");
		//	$this->obj_adminstration->updateModifyDate();
			ob_clean();
			$msg=getmessage('COM_DEL_SUCC');
			print "<script>callmsg('".$msg."');</script>";
			$this->_leaveSchemeList($_SESSION['id_company']);
		}
	}
	
	
	function _companyproperty($x=1) {
	    if($_SESSION['id_company']){
     	$sql_property="select * from ".TABLE_PREFIX."propertyType";
   	    $uri ='index.php/adminstration/companyproperty';
      	$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Property List";
		$this->_output['field'] = array("type_name"=>array("Property Type Name", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql_property;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "type_name";
		//$result=getrows($sql_property,$err);
		$this->_input['qstart']=$this->_input['qstart'];
       if(isset($this->_input['qstart']) || $x)
        {
			$this->_input['choice']='companyproperty';
			$this->adminstration_bl->page_listing($this,"adminstration/propertylist");
         }
        }
       }
       
       	function _addproperty(){
		if($_SESSION['id_company']){
 			$this->_output['tpl']="adminstration/addproperties";
		}else{
			redirect(LBL_SITE_URL);
		}
	}
	
	function _editproperty($id=""){
       	if($_SESSION['id_company']){
			$arr['id']=$this->_input['id'];
   		$sql_property="select * from ".TABLE_PREFIX."propertyType where id_property_type=".$this->_input['id_property'];

   			$res=getsingleindexrow($sql_property,$err);
       		$this->_output['property_edit']=$res;
  			$this->_output['tpl']="adminstration/addproperties";
 	}else{
   redirect(LBL_SITE_URL);
		}
	}
	
		function _insertproperty(){
 		$arr['type_name ']=$this->_input['property']['type_name'];
 		$arr['type_description']=$this->_input['property']['type_description'];
      	$this->obj_adminstration->insert($arr,"propertyType");
        $msg=getmessage('COM_INS_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
       $this->_companyproperty($_SESSION['id_company']);

	}
	
		function _updateproperty(){

 		$arr['type_name']=$this->_input['property']['type_name'];
   		$arr['type_description']=$this->_input['property']['type_description'];
   		$res=$this->obj_adminstration->update("propertyType",$arr,"id_property_type=".$this->_input['property']['temp_id']);
        $msg=getmessage('COM_UPD_SUCC');
	    print "<script>callmsg('".$msg."');</script>";
       $this->_companyproperty($_SESSION['id_company']);

	}
	
		function _deleteproperty(){
	    	if($_SESSION['id_company']){
  			$this->obj_adminstration->delete($this->_input['id_property'],"id_property_type","","propertyType");

			ob_clean();
			$msg=getmessage('COM_DEL_SUCC');
			print "<script>callmsg('".$msg."');</script>";
			$this->_companyproperty($_SESSION['id_company']);
		}
      }

}//end of class
