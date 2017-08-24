<?php
/**
 * Class   : leave_manager
 * Purpose : All Leave coding done here.
 */
class leave_manager extends mod_manager {
#######################################################################################################
### Function Name : leave_manager	  						    ###
### Description   : This is a constructor 							    ###					 
### Input         : Reference of smarty,input and output parameters 	  			    ###
### Output	  : Initiates mod manager and initialize object and business class for user manager ###
#######################################################################################################
	function leave_manager (& $smarty, & $_output, & $_input) {
 if($_REQUEST['ce']!='0'){
	    		check_session();
	    	}else{
			//for autocomplete and fancybox
	    		if(!$_SESSION['id_user'] && $_REQUEST['for']=='auto'){
				//exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>|abc::".getmessage('COM_NO_SESSION'));
				exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>|abc::nosession");
			}elseif(!$_SESSION['id_user']){
	    			exit("nosession");
	    		}
	    	}
		$this->mod_manager($smarty, $_output, $_input,'leave');
		$this->obj_leave= new leave;
		$this->leave_bl = new leave_bl;
 	}
#########################################################################################
### Function Name : get_module_name(Predefined Function)			      ###
#########################################################################################
	function get_module_name() { 
		return 'leave';
	}
#########################################################################################
### Function Name : get_manager_name(Predefined Function) 			      ###
#########################################################################################
	function get_manager_name() {
		return 'leave';
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
### Function Name : _leaveTypes		   					       ###
### Description   : Function to show listing of leaveTypes of company. 		       ###
### Input         : No input 							       ###
### Ouput 	  : Editable leaveType  template       		       	 	       ###
##########################################################################################
	function _leaveTypes(){
		$uri="index.php/page-leave-choice-leaveTypes";
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
			$this->leave_bl->page_listing($this,'leave/leaveType');
		}else{
			$this->leave_bl->page_listing($this,'leave/leaveTypeSearch');
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
		$this->obj_leave->insert($arr,"companyLeaveType");
		$this->_output['qstart'] =$this->_input['qstart'];
		$_SESSION['raise_message']['global'] = getmessage('COM_INS_SUCC');
		redirect(LBL_SITE_URL.'index.php/leave/leaveTypes');
	}

##########################################################################################
### Function Name : _updateLeave						       ###
### Description   : Function to update leave Types of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _leaveTypes() function		       		       ###
##########################################################################################
	function _updateLeavetype(){
		$arr['leave_type']=$this->_input['leave_type'];
		$this->obj_leave->updateall("companyLeaveType",$arr,"id_leave_type=".$this->_input['temp_id']);
		$_SESSION['raise_message']['global'] = getmessage('COM_UPD_SUCC');
		$_SESSION['leave_qs']=$this->_input['qstart'];
		redirect(LBL_SITE_URL.'index.php/leave/leaveTypes');
	}
##########################################################################################
### Function Name : _deleteLeave						       ###
### Description   : Function to delete leave Types of company			       ###
### Input         : No input 							       ###
### Ouput	  : Redirect to _leaveTypes() function		       		       ###
##########################################################################################
	function _deleteLeave(){
		$r=$this->obj_leave->delete($this->_input['id'],"id_leave_type","","companyLeaveType");
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
# Function Name : _leaveRequest                                                                     #
# Description   : List of employee leave request         					    #
#		                      	                                                            #
# Input         : No Input                                                                          #
# Output	: leaveRequestList or leaveRequestSearch template according to condition            #
#####################################################################################################
	function _leaveRequest($leavestatus='',$flag='',$msg=''){
		if($flag==''){
			$leavestatus=$this->_input['leavestatus'];
		}
		$this->_output['res_personal']=$res_personal;
		$cond="1 ";

		if($_SESSION['id_company']){
			$cond.= " AND id_company=".$_SESSION['id_company'];
		}else if($_SESSION['id_employee']){
			$cond.= " AND id_employee=".$_SESSION['id_employee'];
		}else{
			redirect(LBL_SITE_URL);
		}
		// for different message
		if($this->_input['msg']!=''){
			$_SESSION['amsg']=$this->_input['msg'];
		}elseif($msg){
			$_SESSION['amsg']=$msg;
		}else{
			$_SESSION['amsg']="";
		}
		// end
		if($this->_input['f']=='for_del'){
			$_SESSION['amsg']=$this->deleteLeave($this->_input['keys']);
		}
		if($this->_input['qs']!=''){
			$this->_input['qstart']=$this->_input['qs'];
		}
		$_REQUEST['choice']='leaveRequest';

		$uri="index.php/page-leave-choice-leaveRequest";
		// for filter on leave status
		$leavestatus=trim($leavestatus,',');
		if($leavestatus!='' && $_SESSION['id_company']){
			$search_cond=" AND leave_status IN (".$leavestatus.")";
			$uri.="-leavestatus-".$leavestatus;

		}elseif(!$this->_input['chk'] && $_SESSION['id_company']){
			$search_cond=" AND leave_status IN (1)";
			$uri.="-leavestatus-1";
		}

		$sql=get_search_sql("employeeLeaveRequest",$cond.$search_cond);
		//print $sql;
		$this->_output['sql'] = $sql;
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['ajax']= "leaveRequest";
		$this->_output['uri'] = $uri;
		$this->_output['type'] = "box";
		$this->_output['pg_header'] = "Leave Request List";
		$this->_output['sort_order'] = "DESC";
		$this->_output['sort_by'] = "id_leave_req";
		$this->_output['show']=$GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['field'] = array("name"=>array("Name",1));

		$this->_output['leave_type_res']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyLeaveType","'."".'")',"id_leave_type","leave_type",$err);

		$this->_output['status']=$GLOBALS['conf']['LEAVE_STATUS'];

		$this->_output['employee']=$this->leave_bl->getEmployees($cond);

		if($this->_input['chk']){
			$arr = explode(",",$leavestatus);
			$this->_output['leavestatus']= array_combine($arr,$arr);
			$this->leave_bl->page_listing($this,'leave/leaveRequestList');
		}else{
			$this->_output['leavestatus']= array("1"=>"1");
			$_SESSION['amsg']='';
			$this->leave_bl->page_listing($this,'leave/leaveRequestSearch');
		}
	}
   #####################################################################################################
# Function Name : _addLeave                	                                                    #
# Description   : Give an ui to apply leave	         					    #
#		                      	                                                            #
# Input         : No Input                                                                          #
# Output	: addLeave template							            #
#####################################################################################################
	function _addLeave(){
		$leave_type_sql='CALL get_search_sql("'.TABLE_PREFIX.'companyLeaveType","'."".'")';
		$this->_output['leave_type_res']=getindexrows($leave_type_sql,"id_leave_type","leave_type");
	//	print_r($this->_output['leave_type_res']);
		$this->_output['status']=$GLOBALS['conf']['LEAVE_STATUS'];
		$this->_output['tpl']="leave/addLeave";
	}
#####################################################################################################
# Function Name : _insertLeave                	                                                    #
# Description   : Insert an employee     	         					    #
#		                      	                                                            #
# Input         : No Input                                                                          #
# Output	: call to leaveRequest function 					            #
#####################################################################################################
	function _insertLeave(){
		global $link;
		$leave=$this->_input['leave'];
		$leave['id_employee']=$_SESSION['id_employee'];
		$res=getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'employee","'."id_employee=".$_SESSION['id_employee']." LIMIT 1".'")');

		$leave['id_company']=$res['id_company'];
		$leave['leave_status']=1;
		$date=explode("to",$this->_input['leave_date']);
		$leave['from_date']=convertodate(trim($date[0]),'dd-mm-yy','yyyy-mm-dd');
		$leave['to_date']=convertodate(trim($date[1]),'dd-mm-yy','yyyy-mm-dd');
	//	print_r($leave);

		$id=$this->obj_leave->insertarray("employeeLeaveRequest",$leave);

		// Mailing leave request details to company admin
		if($id){
			$res_company=getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'company","'."id_company=".$res['id_company']." LIMIT 1".'")');

			$to = $res_company['email_id'];

			$from = $_SESSION['username'];
			$subject = "Leave Request";

			$info=$leave;
			$info['username']=$arr['username'];

			$tpl= "leave/mailLeaveRequest";
			$this->smarty->assign('sm',$info);
			$leave_type_res=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyLeaveType","'."".'")',"id_leave_type","leave_type",$err);

			$this->smarty->assign('leavetype',$leave_type_res);
			$body = $this->smarty->fetch($this->smarty->add_theme_to_template($tpl));
			$msg=sendmail($to,$subject,$body,$from);// also u can pass  $cc,$bcc
		}
		// end
		if($id){
			$this->obj_leave->updateModifyDate();
			$msg = getmessage('EMP_LEAVE_APPLY_SUCC');
		}else{
			$msg = getmessage('EMP_LEAVE_APPLY_FAIL');
		}
	        $this->mail4NotificationOfEvent("2","Applied a leave");
		ob_clean();
		$this->_leaveRequest('','',$msg);
	}
#####################################################################################################
# Function Name : _editLeave                	                                                    #
# Description   : Gives ui to edit leave request        					    #
#		                      	                                                            #
# Input         : No Input                                                                          #
# Output	: addLeave template    		 					            #
#####################################################################################################
	function _editLeave(){
		global $link;
		if($_SESSION['id_company']){
			$cond=" id_company=".$_SESSION['id_company'];
		}else{
			$cond=" id_employee=".$_SESSION['id_employee'];
		}
		$this->_output['id']=$this->_input['id_leave'];
		$sql='CALL get_search_sql("'.TABLE_PREFIX.'employeeLeaveRequest","'."id_leave_req='".$this->_input['id_leave']."' AND ".$cond." LIMIT 1".'")';

		$this->_output['res']=getsingleindexrow($sql);

		$leave_type_sql='CALL get_search_sql("'.TABLE_PREFIX.'companyLeaveType","'."".'")';

		$this->_output['leave_type_res']=getindexrows($leave_type_sql,"id_leave_type","leave_type");
		$this->_output['status']=$GLOBALS['conf']['LEAVE_STATUS'];
		$this->_output['tpl']="leave/addLeave";
	}
#####################################################################################################
# Function Name : _updateLeave                	                                                    #
# Description   : Updates leave request        					 		    #
#		                      	                                                            #
# Input         : id_leave_req                                                                      #
# Output	: call to leaveRequest function 					            #
#####################################################################################################
	function _updateLeave(){
		if($_SESSION['id_company']){
			$cond=" id_company=".$_SESSION['id_company'];
		}else{
			$cond=" id_employee=".$_SESSION['id_employee'];
		}
		$leave=$this->_input['leave'];
		$date=explode("to",trim($this->_input['leave_date']));

		$leave['from_date']=convertodate(trim($date[0]),'dd-mm-yy','yyyy-mm-dd');
		$leave['to_date']=convertodate(trim($date[1]),'dd-mm-yy','yyyy-mm-dd');

		$r=$this->obj_leave->update("employeeLeaveRequest",$leave,"id_leave_req=".$this->_input['upd_id']." AND ".$cond);
		if($r){
			$msg = getmessage('COM_UPD_SUCC');
		}else{
			$msg = getmessage('COM_UPD_FAIL');
		}
	        $this->mail4NotificationOfEvent("2","Updated applied leave");
		$this->obj_leave->updateModifyDate();
		ob_clean();
		$this->_input['qstart']=$this->_input['qstart'];
		$this->_leaveRequest($this->_input['leavestatus'],1,$msg);
	}
#####################################################################################################
# Function Name : deleteLeave                	                                                    #
# Description   : Deletes leave request        					 		    #
#		                      	                                                            #
# Input         : id_leave_req                                                                      #
# Output	: return deletion message  	 					            #
#####################################################################################################
	function deleteLeave($keys=''){
		if($_SESSION['id_company']){
			$cond=" id_company=".$_SESSION['id_company'];
		}else{
			$cond=" id_employee=".$_SESSION['id_employee'];
		}
		$r=$this->obj_leave->deleteleave("employeeLeaveRequest"," id_leave_req IN (".$keys.") AND ".$cond);
	        $this->mail4NotificationOfEvent("2","Deleted applied leave");
		if($r){
			$this->obj_leave->updateModifyDate();
			$msg = getmessage('EMP_LEAVE_DEL_SUCC');
		}else{
			$msg = getmessage('EMP_LEAVE_DEL_FAIL');
		}
		return $msg;
	}
#####################################################################################################
# Function Name : _updateLeaveStatus           	                                                    #
# Description   : Updates leave request        					 		    #
#		                      	                                                            #
# Input         : id_leave_req                                                                      #
# Output	: call to leaveRequest function	 					            #
#####################################################################################################
	function _updateLeaveStatus(){
		global $link;
		if($_SESSION['id_company']){
			$cond=" id_company=".$_SESSION['id_company'];
		}else{
			$cond=" id_employee=".$_SESSION['id_employee'];
		}
		$leave['leave_status']=$this->_input['status'];
		$r=$this->obj_leave->update("employeeLeaveRequest",$leave,"id_leave_req=".$this->_input['id_leave']." AND ".$cond);

		// Mailing leave request details to company admin
		if($r){
			$res=getsingleindexrow(get_search_sql("employeeLeaveRequest ELR,".TABLE_PREFIX."employee E","ELR.id_employee=E.id_employee AND id_leave_req=".$this->_input['id_leave']." LIMIT 1"));

			$to = $res['work_email'];
			$from = $_SESSION['username'];
			$subject = "Leave Status";
			$info=$res;
			$info['leave_status']=$this->_input['status'];

			$tpl= "leave/mailLeaveStatus";
			$this->smarty->assign('sm',$info);
			$body = $this->smarty->fetch($this->smarty->add_theme_to_template($tpl));
			$msg=sendmail($to,$subject,$body,$from);// also u can pass  $cc,$bcc
		}
		// end
		if($r){
			$this->obj_leave->updateModifyDate();
			$msg=getmessage('COM_UPD_SUCC');
		}else{
			$msg=getmessage('COM_UPD_FAIL');
		}
		ob_clean();
		$this->_leaveRequest('','',$msg);
	}
	#####################################################################################################
# Function Name : mail4NotificationOfEvent   		                                            #
# Description   : Sends mail to admin(s) if employee modify some of data	 		    #
#		                      	                                                            #
# Input         : No Input                                                                          #
# Output	: No Output 	 					   		            #
#####################################################################################################
	function mail4NotificationOfEvent($flg,$upd_page=''){
		$info['update_page'] = $upd_page;
		$info['name'] = $_SESSION['fullname'];
		$info['email'] = $_SESSION['username'];
		$info['flag'] = $flg;
		$tpl= "leave/mail4NotificationOfEvent";

		$res=getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'companyNotification","'."id_company='".$_SESSION['emp_company']."' LIMIT 1".'")');
		$res_admin=getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'company","'."id_company='".$_SESSION['emp_company']."' LIMIT 1".'")');

		$from = $res_admin['email_id'];
		$to = $res_admin['email_id'];
		$subject='';
		if($flg==2){
			if($res['emp_modify']==1){
				$subject = "Employee Modification";
			}
			if($_SESSION['id_company']){
				$info['email'] = $_SESSION['emp_email'];
			}
		}
		if($_SESSION['id_company'] && $flg==1){
			if($res['emp_add']==1){
				$info['email']=$upd_page;
				$subject = "Employee Added";
			}
		}
		if($_SESSION['id_company'] && $flg==3){
			if($res['emp_remove']==1){
				$this->smarty->assign('emps',$upd_page);
				$subject = "Employee Deleted";
			}
		}
		if($subject!=''){
			$this->smarty->assign('sm',$info);
			$body = $this->smarty->fetch($this->smarty->add_theme_to_template($tpl));
			$msg=sendmail($to,$subject,$body,$from);
			if($res['id_employee']){
				$res_2lvl_admin=getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'employee","'."id_employee='".$res['id_employee']."' LIMIT 1".'")');
				$to = $res_2lvl_admin['work_email'];
				$msg=sendmail($to,$subject,$body,$from);
			}
		}
	}
}//end of class
