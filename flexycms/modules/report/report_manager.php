<?php
/**
 * Class   : report_manager
 * Purpose : All report module coding done here. 
 */
class report_manager extends mod_manager {
#######################################################################################################
### Function Name : report_manager	  					           	    ###
### Description   : This is a constructor 							    ###					 
### Input         : Reference of smarty,input and output parameters 	  			    ###
### Output	  : Initiates mod manager and initialize object and business class for user manager ###
#######################################################################################################
	function report_manager (& $smarty, & $_output, & $_input) {
		if($_REQUEST['ce']!='0'){
	    		check_session();
	    	}else{
	    		if(!$_SESSION['id_user']){
	    			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."Please <a href='javascript:void(0);' onclick=check_JSsession('nosession',0); style='text-decoration : underline;'>click</a> here to log in again</span>");
	    		}
	    	}
		$this->mod_manager($smarty, $_output, $_input, 'report');
		$this->obj_report = new report;
		$this->report_bl = new report_bl;
 	}
#########################################################################################
### Function Name : get_module_name(Predefined Function)			     ####
#########################################################################################
	function get_module_name() { 
		return 'report';
	}
##########################################################################################
### Function Name : get_manager_name(Predefined Function) 			       ###
##########################################################################################
	function get_manager_name() {
		return 'report';
	}
##########################################################################################
### Function Name : default(Predefined Function) 		  		       ###
### Description   : Handle default request(if no choice specified)                     ###
##########################################################################################
	function _default() {
		return true;
	}
##########################################################################################
### Function Name : manager_error_handler					       ###
### Description   : Function to handle error when choice not found                     ###
### Input         : No input 						   	       ###
### Ouput         : Error handling template.		         		       ###
##########################################################################################
	function manager_error_handler() {
		$call = "_".$this->_input['choice'];
		if (function_exists($call)) {
			$call($this);
		} else {
			//Put your own error handling code here;
			$this->_output['tpl']='default/error_handler';
		}
	}
#########################################################################################
### Function Name : _genderProfile					      	      ###
### Description   : Function to show Gender status in bar and pie chart of company    ###
### Input         : No input 						      	      ###
### Ouput	  : General genderProfile template            	                      ###
#########################################################################################
	function _genderProfile() { 
		$sql="SELECT gender,COUNT(*) AS cnt FROM (SELECT id_employee,emp_status,joined_date,gender FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE id_company=".$_SESSION['id_company']." AND IF(terminate_date!='',terminate_date > NOW(),1)) AS RES GROUP BY gender DESC";
		$res=getrows($sql,$err);
		for($i=0;$i < count($res); $i++){
			if($res[$i]['gender'] == 'M')
				$this->_output['male'] = $res[$i]['cnt'];
			else
				$this->_output['female'] = $res[$i]['cnt'];

		}		
		$this->_output['tpl'] ='report/genderProfile';
	}
#########################################################################################
### Function Name : _ageProfile					      	              ###
### Description   : Function to show age status in bar and pie chart of company       ###
### Input         : No input 						      	      ###
### Ouput	  : General ageProfile template            	                      ###
#########################################################################################
	function _ageProfile() {
		global $link;
		$sql_emp_cnt = "SELECT COUNT(*) AS emp_cnt FROM ".TABLE_PREFIX."employee LIMIT 1";
		$emp_cnt = getsingleindexrow($sql_emp_cnt);	
		if($emp_cnt['emp_cnt']){
			$sql_age_group = "SELECT * FROM ".TABLE_PREFIX."agegroup ORDER BY start_age ASC";
			$ret_age_group=$link->query($sql_age_group);		

			$sql_age="SELECT age FROM (SELECT id_employee,CEIL(DATEDIFF(NOW(),dob)/365) AS age,emp_status,joined_date FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE id_company=".$_SESSION['id_company']." AND IF(terminate_date!='',terminate_date > NOW(),1)) AS RES WHERE age!='null'";
			$num=0;
			//print $sql_age;exit;
			while($ret=mysqli_fetch_assoc($ret_age_group)){
				$ret_age=$link->query($sql_age);
				$x[$ret['age_limit']][1]=0;
				while($ret2=mysqli_fetch_assoc($ret_age)){
					if($ret['end_age'] == 'up') {
						if($ret2['age'] >= $ret['start_age']) {
							$x[$ret['age_limit']][0]=$ret['age_limit'];
							$x[$ret['age_limit']][1] += 1;
							$num++;
						}
					}elseif($ret2['age'] >= $ret['start_age'] && $ret2['age'] <= $ret['end_age']){
						$x[$ret['age_limit']][0]=$ret['age_limit'];
						$x[$ret['age_limit']][1] += 1;
						$num++;
					}	
					else{
						$x[$ret['age_limit']][0]=$ret['age_limit'];
					}
			
				}
			}
		//	print_r(array_values($x));
		//	echo '<br>';
		//		print_r(json_encode(array_values($x)));
			$this->_output['arr']=array_values($x);
			$this->_output['x'] = json_encode(array_values($x));
		}
		$this->_output['tpl'] ='report/ageProfile';
	}
#########################################################################################
### Function Name : _leaveSummery				      	              ###
### Description   : Function to show leave summery with a search form 		      ###
### Input         : No input 						      	      ###
### Ouput	  : General searchLeave template            	                      ###
#########################################################################################
	function _leaveSummery(){
		$sql=get_search_sql("companyLeaveType");
		$res=getindexrows($sql,"id_leave_type","leave_type");
		$this->_output['leave_type'] =$res;
		$uri = 'index.php/page-report-choice-leaveSummery';
		$cond=1;
		if($this->_input['leave_type']){
			$cond.=" AND leave_type ='".$this->_input['leave_type']."'";
			$uri .= '-leave_type-'.$this->_input['leave_type'];
		}
		if($this->_input['id_employee']){
			$cond.=" AND e.id_employee ='".$this->_input['id_employee']."'";
			$uri .= '-id_employee-'.$this->_input['id_employee'];
		}
		$frmdate=$this->_input['frm_date'];
		$tmp_frmdate=str_replace("**","-",$frmdate);
		$todate=$this->_input['to_date'];
		$tmp_todate=str_replace("**","-",$todate);
		
		if($this->_input['group_by']=='2'){
			$group_by=' e.id_employee ';
			$uri .= '-group_by-'.$this->_input['group_by'];
		}else{
			$group_by=' CONCAT(e.leave_type,e.id_employee) ';
			$uri .= '-group_by-1';
		}
		$con_frmdate=convertodate($tmp_frmdate,'dd-mm-yy','yyyy-mm-dd');
		$con_todate=convertodate($tmp_todate,'dd-mm-yy','yyyy-mm-dd');
		if($frmdate!='' && $todate!=''){
			$cond.=" AND ( ( '".$con_frmdate."' <= e.from_date AND '".$con_todate."' >= e.from_date ) ";
			$cond.=" OR ( '".$con_frmdate."' <= e.to_date AND '".$con_todate."' >= e.to_date )  ";
			$cond.=" OR ( '".$con_frmdate."' <= e.from_date AND '".$con_todate."' >= e.to_date )  ";
			$cond.=" OR ( '".$con_frmdate."' >= e.from_date AND '".$con_todate."' <= e.to_date ) ) ";
			$uri .= '-frm_date-'.str_replace("-","**",$frmdate);
			$uri .= '-to_date-'.str_replace("-","**",$todate);
		}else if($frmdate!=''){
			$cond.=" AND ( '".$con_frmdate."' <= e.from_date OR ( e.from_date <= '".$con_frmdate."' AND '".$con_frmdate."' <= e.to_date ) ) ";
			$uri .= '-frm_date-'.str_replace("-","**",$frmdate);
		}else if($todate){
			$cond.=" AND ( '".$con_todate."' >= e.to_date  OR ( e.from_date <= '".$con_todate."' AND '".$con_todate."' <= e.to_date ) )";
			$uri .= '-to_date-'.str_replace("-","**",$todate);
		}
		
		$sql='SELECT id_employee,leave_status,leave_type, (SELECT CONCAT(firstname," ",lastname) as name FROM '.TABLE_PREFIX.'employee WHERE id_employee=e.id_employee) as name,sum(work_days) as total,(SELECT leave_type from '.TABLE_PREFIX.'companyLeaveType as leave_type WHERE id_leave_type=e.leave_type ) as ltype,from_date,to_date FROM '.TABLE_PREFIX.'employeeLeaveRequest e WHERE id_company='.$_SESSION['id_company'].' AND leave_status=2 AND '.$cond.' GROUP BY '.$group_by;
		$_SESSION['ls_cond']=$cond;
		$_SESSION['ls_group_by']=$group_by;
		//print $sql;
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Employee Leaves";
		$this->_output['field'] = array("name"=>array("Name", 1),"total"=>array("Total Leaves", 1), "ltype"=>array("Leave Type",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "name";
		if(isset($this->_input['qstart']) || isset($this->_input['search_status'])){
			$this->report_bl->page_listing($this,"report/leaveSummeryListing"); 
		}else{
			$this->report_bl->page_listing($this,"report/searchLeave"); 
		}
	}
#########################################################################################
### Function Name : _leaveDetail				      	              ###
### Description   : Function to show leave detail of an employee 		      ###
### Input         : Employee id						      	      ###
### Ouput	  : General leaveDetail template            	                      ###
#########################################################################################
	function _leaveDetail(){
		if(!$_SESSION['id_user']){
			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>");
		}
		$sql=get_search_sql("companyLeaveType");
		$res=getindexrows($sql,"id_leave_type","leave_type");
		$this->_output['leave_type'] =$res;
		$uri = 'index.php/page-report-choice-leaveDetail';
		$uri.="-id-".$this->_input['id'];
		if($this->_input['group_by']==1){
			$cond='leave_type="'.$this->_input['ltype'].'"';
			$uri.="-group_by-".$this->_input['group_by'];
			$uri.="-ltype-".$this->_input['ltype'];
		}else{
			$cond='1';
		}
		
		$sql='SELECT * FROM (SELECT id_employee,leave_status,leave_type,notes, (SELECT concat(firstname," ",lastname) as name FROM '.TABLE_PREFIX.'employee WHERE id_employee=e.id_employee) as name,work_days as total,(SELECT leave_type from '.TABLE_PREFIX.'companyLeaveType as leave_type WHERE id_leave_type=e.leave_type ) as ltype,from_date,to_date FROM '.TABLE_PREFIX.'employeeLeaveRequest e WHERE id_company='.$_SESSION['id_company'].' AND leave_status=2 AND '.$_SESSION['ls_cond'].' ) TEMP WHERE '.$cond.' AND id_employee='.$this->_input['id'];

		//print $sql;
		
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Leave Details ";
		$this->_output['field'] = array("name"=>array("Name", 1),"total"=>array("Working Days", 1), "leave_type"=>array("Leave Type",1),"notes"=>array("Notes",0),"from_date"=>array("From",1),"to_date"=>array("To",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "leave_type";
		$this->report_bl->page_listing($this,"report/leaveDetail"); 
	}
##########################################################################################
### Function Name : _auto_complete						       ###
### Description   : Function show employeename with photo as facebook in notification  ###
### Input         : No input 							       ###
### Ouput	  : auto_complete template 				       	       ###
##########################################################################################
	function _auto_complete(){
		if(!$_SESSION['id_user']){
			exit;
		}
		$sql="SELECT firstname,middlename,lastname FROM ".TABLE_PREFIX."employee where firstname like '".$this->_input['q']."%' OR middlename like '".$this->_input['q']."%' OR lastname like '".$this->_input['q']."%'";
		$res=getrows($sql,$err);
		foreach ($res as $k => $v){
			if($res[$k]['middlename']){
				$res1[$k]['name']=$res[$k]['firstname']." ".$res[$k]['middlename']." ".$res[$k]['lastname'];
			}else{
				$res1[$k]['name']=$res[$k]['firstname']." ".$res[$k]['lastname'];
			}
		}
		$this->_output['res']=$res1;
		$this->_output['tpl'] ="report/auto_complete";	
	}

#########################################################################################
### Function Name : _phoneNumbers				      	              ###
### Description   : Function to show phone numbers of all employee of company	      ###
### Input         : No input 						      	      ###
### Ouput	  : General phoneNumbers template            	                      ###
#########################################################################################
	function _phoneNumbers(){
		$sql="SELECT id_employee,emp_status,joined_date,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,mobile_phone,home_phone,work_phone FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE IF(terminate_date!='',terminate_date > NOW(),1) AND id_company=".$_SESSION['id_company'];
		
		//print $sql;
		$uri = 'index.php/page-report-choice-phoneNumbers';
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "phone Number List";
		$this->_output['field'] = array("firstname"=>array("Name", 1),"mobile_phone"=>array("GSM Number", 1),"home_phone"=>array("Home Number", 1),"work_phone"=>array("Company Number", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_employee";
		$this->report_bl->page_listing($this,"report/phoneNumbers"); // Pass the template name as a 3rd optional parameter.
	}
#########################################################################################
### Function Name : _companyProperties				      	              ###
### Description   : Function to show company properties of company	      	      ###
### Input         : No input 						      	      ###
### Ouput	  : General phoneNumbers template            	                      ###
#########################################################################################
	function _companyProperties(){
		$sql="SELECT TE.id_employee,emp_status,joined_date,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,EP.property_name,EP.serial_no,EP.notes,EP.no_of_items FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE,".TABLE_PREFIX."employeeProperties EP WHERE TE.id_employee=EP.id_employee AND IF(terminate_date!='',terminate_date > NOW(),1) AND TE.id_company=".$_SESSION['id_company'];

		$uri = 'index.php/page-report-choice-companyProperties';
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Company Properties List";
		$this->_output['field'] = array("firstname"=>array("Name and surname", 1),"property_name"=>array("Model", 1),"serial_no"=>array("Serial", 1),"notes"=>array("Notes", 1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "id_employee";
		$this->report_bl->page_listing($this,"report/companyProperties"); // Pass the template name as a 3rd optional parameter.
	}
#########################################################################################
### Function Name : _employment_status				      	              ###
### Description   :							      	      ###
### Input         : No input 						      	      ###
### Ouput	  : employment_status template            	                      ###
#########################################################################################
	function _employment_status(){
		global $link;
		$ret=$GLOBALS['conf']['EMPLOYMENT_STATUS'];
			
		$sql_emp_cnt = "SELECT COUNT(*) AS emp_cnt FROM ".TABLE_PREFIX."employee LIMIT 1";
		$emp_cnt = getsingleindexrow($sql_emp_cnt);	
		if($emp_cnt['emp_cnt']){		
			$sql="SELECT emp_status,COUNT(*) AS cnt FROM (SELECT id_employee,emp_status,joined_date,gender FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE id_company=".$_SESSION['id_company']." AND IF(terminate_date!='',terminate_date > NOW(),1)) AS RES GROUP BY emp_status ASC";
		
			$data=$this->mygetrows($sql,$err,$ret);
			$this->_output['arr']=$data;
			$this->_output['x']=json_encode($data);
		}
		$this->_output['tpl']= "report/employment_status";
	}
#########################################################################################
### Function Name : mygetrows     				      	              ###
### Description   : It fetches age groupwise data			      	      ###
### Input         : No input 						      	      ###
### Ouput	  : return fetched data                  	                      ###
#########################################################################################
	function mygetrows($sql,&$err,$ret){
		global $stats,$func_name,$link;
		$keys=array_keys($ret);
		$time_start = getmicrotime();
		$i=0;
		$tot=0;
		$k=-1;
		$sth = execute($sql,$err);	
		if($err)	return $err;
		if ($sth) {
			do {
				if ($result = $link->store_result()) {
					while ($row = $result->fetch_assoc()) {
						$myres[$i][1] =(int) $row['cnt'];
						$myres[$i][0] = $ret[$row['emp_status']];
						$tmp_keys[]=$row['emp_status'];
						$tot=$tot+(int) $row['cnt'];
						if($row['emp_status']==2){
							$k=$i;
						}
						$i++;
					}
					$result->close();
				}
			} while ($link->next_result());
			$tmp_arr=array_diff($keys,$tmp_keys);
			foreach($tmp_arr as $val){
				if($val==2){
					$k=$i;
				}else{
					$myres[$i][1] = 0;
				}
				$myres[$i][0] = $ret[$val];
				$i++;
			}
			$sql_emp="SELECT id_employee,id_company FROM ".TABLE_PREFIX."employee WHERE id_company=".$_SESSION['id_company'];
			$tot_emp=mysqli_num_rows($link->query($sql_emp));
			if($k!=-1){
				$myres[$k][1]=$tot_emp-$tot;
			}
		} else {
			printf("<br />First Error: %s\n", $link->error);
			exit;
		}
		if(!isset($myres)) $myres = array();
		$stats['func'][$func_name]['sql'][count($stats['func'][$func_name]['sql'])-1]['sql']['records'] = count($myres) ;
		return ((is_array($myres))? $myres : array());
	}
#########################################################################################
### Function Name : _exportUsers				      	              ###
### Description   :							      	      ###
### Input         : No input 						      	      ###
### Ouput	  : General exportUsers template            	                      ###
#########################################################################################
	function _exportUsers(){
		$this->_output['tpl']= "report/exportUsers";
	}
#########################################################################################
### Function Name : _generateCsv				      	              ###
### Description   : Function call the sth2csv function with required data      	      ###
### Input         : No input 						      	      ###
### Ouput	  : 				            	                      ###
#########################################################################################
	function _generateCsv(){
		global $link;
		$sql="SELECT firstname,middlename,lastname,dob,nationality,gender,ssn_no,address,city,state,country,zipcode,home_phone,work_phone,mobile_phone,work_email,other_email,emp_status,joined_date,salary,currency,pay_frequency,marital_status,dl_no,(select dept_name FROM ".TABLE_PREFIX."companyDepartment where id_department=department) as department,(select div_name FROM ".TABLE_PREFIX."companyDivision where id_division=division) as division,(select job_title_name FROM ".TABLE_PREFIX."companyJobTitle where id_job_title=job_title) as job_title  FROM ".TABLE_PREFIX."employee";
		$arr=array('firstname','middlename', 'lastname', 'dob', 'nationality', 'gender', 'ssn_no', 'address', 'city','state','country','zipcode','home_phone','work_phone','mobile_phone','work_email','other_email','emp_status','joined_date','salary','currency','pay_frequency','marital_status','dl_no','department','division','job_title');
		$this->_sth2csv('emp.csv',$sql,$arr);
	}
#########################################################################################
### Function Name : _sth2csv				      	                      ###
### Description   : Function generates the csv file of all employee of company        ###
### Input         : No input 						      	      ###
### Ouput	  : opens a window with save and open option and down the file        ###
#########################################################################################
	function _sth2csv($filename="",$sql,$arr_field=""){
		global $link;
		$flag=true;
		$sth = execute($sql,$err);
		if ($sth) {
			do {
				if ($result = $link->store_result()) {
					while($data = $result->fetch_assoc()){
						$i=0;
						if($flag){
							if(is_array($arr_field)){
								$key=$arr_field;
							}else{
								$key=array_keys($data);
							}
							$content=implode(',',$key);
							$content.="\n";
							$flag=false;
						}
						if(is_array($arr_field)){
							foreach($arr_field as $k=>$v)
								$a[$i++]=$data[$v];
						}else{
							$a=$data;
						}
						$content.=implode(',',$a);
						$content.="\n";
					}
					$result->close();
				}
			} while ($link->next_result());

			if($filename){
				header("Content-Disposition: attachment; filename=".$filename."");
				header("Content-Type:application/csv");
			}
			print $content;

		} else {
			printf("<br />First Error: %s\n", $link->error);
			exit;
		}
	}
#########################################################################################
### Function Name : _employeeSalary			      	                      ###
### Description   : Function shows the salry of employees of company                  ###
### Input         : No input 						      	      ###
### Ouput	  : employeeSalList or employeeSalSearch accordingly                  ###
#########################################################################################
	function _employeeSalary(){
		$uri="index.php/page-report-choice-employeeSalary";
		$cond="1 ";
		$cond.=" AND IF(terminate_date!='',terminate_date > NOW(),1) ";
		$sal_range = $this->_input['sal_range'];
		if($sal_range!=''){
			$tmp_sal=explode("-",$GLOBALS['conf']['SEARCH_BY_SALARY'][$sal_range]);
			$sal_start=trim($tmp_sal[0]);
			if(trim($tmp_sal[1])!='up'){
				$sal_end=trim($tmp_sal[1]);
			}else{
				$sal_end=10000000000000;
			}
			$cond.=" AND if(pay_frequency=1,salary*12,(if(pay_frequency=2,salary*52,salary*365))) BETWEEN ".$sal_start." AND ".$sal_end;
			$uri.="-sal_range-".$sal_range;
		}
		$sql=$this->report_bl->getEmployeeSalListSql($cond);		
		//print $sql;
		$this->_output['sql'] = $sql;
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['ajax']= "employeeSalary";		
		$this->_output['uri'] = $uri;
		$this->_output['type'] = "box";
		$this->_output['pg_header'] = "Employee List";
		$this->_output['sort_order'] = "DESC";
		$this->_output['sort_by'] = "id_employee";
		$this->_output['show']=$GLOBALS['conf']['PAGINATE']['show_page'];	
		$this->_output['field'] = array("name"=>array("Name",1),"annual_sal"=>array("Annual Salary",1),"job_title_name"=>array("Job Title",1),"team"=>array("Team",0),"department"=>array("Department",0),"division"=>array("Division",0),"emp_status"=>array("Status",0));
		
		$this->_output['res_terminate']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'employeeTerminationContract","terminate_date < NOW()")',"id_employee","id_employee",$err);
		$this->_output['res_div']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyDivision","id_company='.$_SESSION['id_company'].'")',"id_division","div_name",$err);		
		$this->_output['res_department']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyDepartment","1")',"id_department","dept_name",$err);
		
		$this->_output['res_team']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyTeam","1")',"id_team","team_name",$err);
		
		$this->_output['sal_ranges']= $GLOBALS['conf']['SEARCH_BY_SALARY'];
		
		if($this->_input['chk']){
			$this->report_bl->page_listing($this,'report/employeeSalList');
		}else{
			$this->report_bl->page_listing($this,'report/employeeSalSearch');
		}
	}
#########################################################################################
### Function Name : _employeeJoinings			      	                      ###
### Description   : Function shows the Joinings of employees of company               ###
### Input         : No input 						      	      ###
### Ouput	  : employeeJoiningsList                                              ###
#########################################################################################
	function _employeeJoinings(){
		$uri="index.php/page-report-choice-employeeJoinings";
		$cond="1 ";
		$cond.=" AND IF(terminate_date!='',terminate_date > NOW(),1) ";
		$m = $this->_input['m'];
		$y = $this->_input['y'];
		if($m!=''){
			$cond.=" AND DATE_FORMAT(joined_date,'%m')='".$m."'";
			$uri.="-m-".$m;
		}
		if($y!=''){
			$cond.=" AND DATE_FORMAT(joined_date,'%Y')='".$y."'";
			$uri.="-y-".$y;
		}
		$sql=$this->report_bl->getEmployeeJoiningsListSql($cond);		
		//print $sql;
		$this->_output['sql'] = $sql;
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['ajax']= "employeeJoinings";		
		$this->_output['uri'] = $uri;
		$this->_output['type'] = "box";
		$this->_output['pg_header'] = "Employee List";
		$this->_output['sort_order'] = "DESC";
		$this->_output['sort_by'] = "id_employee";
		$this->_output['show']=$GLOBALS['conf']['PAGINATE']['show_page'];	
		$this->_output['field'] = array("name"=>array("Name",1),"joined_date"=>array("Hire date",1),"annual_sal"=>array("Annual Salary",1),"job_title_name"=>array("Job Title",1),"team"=>array("Team",0),"department"=>array("Department",0),"division"=>array("Division",0),"emp_status"=>array("Status",0));
		
		$this->_output['res_terminate']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'employeeTerminationContract","terminate_date < NOW()")',"id_employee","id_employee",$err);
		$this->_output['res_div']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyDivision","id_company='.$_SESSION['id_company'].'")',"id_division","div_name",$err);		
		$this->_output['res_department']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyDepartment","1")',"id_department","dept_name",$err);
		
		$this->_output['res_team']=getindexrows('CALL get_search_sql("'.TABLE_PREFIX.'companyTeam","1")',"id_team","team_name",$err);
		
		$this->_output['sal_ranges']= $GLOBALS['conf']['SEARCH_BY_SALARY'];
		
		if($this->_input['chk']){
			$this->report_bl->page_listing($this,'report/employeeJoiningsList');
		}else{
			$this->report_bl->page_listing($this,'report/employeeJoiningsSearch');
		}
	}
#########################################################################################
### Function Name : _upcomingBirthdays			      	                      ###
### Description   : Function shows the upcoming birthday of employees of company      ###
### Input         : No input 						      	      ###
### Ouput	  : employeeJoiningsList                                              ###
#########################################################################################
	function _upcomingBirthdays(){
		global $link;
		$uri="index.php/report/upcomingBirthdays/";
		$cond="1 ";
		$cond.=" AND IF(terminate_date!='',terminate_date > NOW(),1) ";
		$m = $this->_input['m'] ? $this->_input['m'] : date(m);
		if(strlen($m) == 1 && $m != 'a') {
			$m = "0".$m;
		}
		$uri.="m-".$m;
		if($m!='a'){
			$this->_output['ctime']  = mktime(0, 0, 0, $m  , date("d"), date("Y"));
			$cond.=" AND DATE_FORMAT(dob,'%m')='".$m."'";
			$this->_output['m'] = $m;
		}		
		$sql=$this->report_bl->getEmployeeUpcomingBirthdayListSql($cond);
		$this->_output['sql'] = $sql;
		$this->_output['limit']= $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['dismon']= $GLOBALS['conf']['DISPLAY_MONTH'];
		$this->_output['ajax']= "employeeList";		
		$this->_output['uri'] = $uri;
		$this->_output['type'] = "box";
		$this->_output['pg_header'] = "Upcoming Birthdays";
		$this->_output['sort_order'] = "DESC";
		$this->_output['sort_by'] = "id_employee";
		$this->_output['show']=$GLOBALS['conf']['PAGINATE']['show_page'];	
		$this->_output['field'] = array("name"=>array("Name",1),"dob"=>array("Date of birth",1));		
		$this->report_bl->page_listing($this,'report/upcomingBirthdays');
	}
	
	
#########################################################################################
### Function Name : _travelSummery			      	                      ###
### Description   : Function shows the travel summary details of employees of company      ###
### Input         : No input 						      	      ###
### Ouput	  : travelsummeryListing tpl file                                              ###
#########################################################################################

    	function _travelSummery(){
		$sql=get_search_sql("companytraveltype");
		$res=getindexrows($sql,"id_travel_type","travel_type");
		$this->_output['travel_type'] =$res;
		$sqltravelmode=get_search_sql("companytravelmode");
		$restravelmode=getindexrows($sqltravelmode,"id_travel_mode","travel_mode");
		$this->_output['travel_mode'] =$restravelmode;
		$uri = 'index.php/page-report-choice-travelSummery';
		$cond=1;
		if($this->_input['travel_type']){
			$cond.=" AND travel_type ='".$this->_input['travel_type']."'";
			$uri .= '-travel_type-'.$this->_input['travel_type'];
		}
		if($this->_input['travel_mode']){
			$cond.=" AND travel_mode ='".$this->_input['travel_mode']."'";
			$uri .= '-travel_mode-'.$this->_input['travel_mode'];
		}
		if($this->_input['id_employee']){
			$cond.=" AND e.id_employee ='".$this->_input['id_employee']."'";
			$uri .= '-id_employee-'.$this->_input['id_employee'];
		}
		$frmdate=$this->_input['frm_date'];
		$tmp_frmdate=str_replace("**","-",$frmdate);
		$todate=$this->_input['to_date'];
		$tmp_todate=str_replace("**","-",$todate);

		if($this->_input['group_by']=='2'){
			$group_by=' e.id_employee ';
			$uri .= '-group_by-'.$this->_input['group_by'];
		}else if($this->_input['group_by']=='3'){
			$group_by=' CONCAT(e.travel_mode,e.id_employee) ';
			$uri .= '-group_by-'.$this->_input['group_by'];
		}
		else
		{
		  	$group_by=' CONCAT(e.travel_type,e.id_employee) ';
			$uri .= '-group_by-1';
			}
		$con_frmdate=convertodate($tmp_frmdate,'dd-mm-yy','yyyy-mm-dd');
		$con_todate=convertodate($tmp_todate,'dd-mm-yy','yyyy-mm-dd');
		if($frmdate!='' && $todate!=''){
			$cond.=" AND ( ( '".$con_frmdate."' <= e.from_date AND '".$con_todate."' >= e.from_date ) ";
			$cond.=" OR ( '".$con_frmdate."' <= e.to_date AND '".$con_todate."' >= e.to_date )  ";
			$cond.=" OR ( '".$con_frmdate."' <= e.from_date AND '".$con_todate."' >= e.to_date )  ";
			$cond.=" OR ( '".$con_frmdate."' >= e.from_date AND '".$con_todate."' <= e.to_date ) ) ";
			$uri .= '-frm_date-'.str_replace("-","**",$frmdate);
			$uri .= '-to_date-'.str_replace("-","**",$todate);
		}else if($frmdate!=''){
			$cond.=" AND ( '".$con_frmdate."' <= e.from_date OR ( e.from_date <= '".$con_frmdate."' AND '".$con_frmdate."' <= e.to_date ) ) ";
			$uri .= '-frm_date-'.str_replace("-","**",$frmdate);
		}else if($todate){
			$cond.=" AND ( '".$con_todate."' >= e.to_date  OR ( e.from_date <= '".$con_todate."' AND '".$con_todate."' <= e.to_date ) )";
			$uri .= '-to_date-'.str_replace("-","**",$todate);
		}

		$sql='SELECT id_employee,travel_status,travel_type,travel_mode, (SELECT CONCAT(firstname," ",lastname) as name FROM '.TABLE_PREFIX.'employee WHERE id_employee=e.id_employee) as name,(SELECT travel_type from '.TABLE_PREFIX.'companytraveltype as travel_type WHERE id_travel_type=e.travel_type ) as traveltype,(SELECT travel_mode from '.TABLE_PREFIX.'companytravelmode as travel_mode WHERE id_travel_mode=e.travel_mode ) as travelmode,from_date,to_date FROM '.TABLE_PREFIX.'employeetravelrequest e WHERE id_company='.$_SESSION['id_company'].' AND travel_status=2 AND '.$cond.' GROUP BY '.$group_by;
		$_SESSION['ls_cond']=$cond;
		$_SESSION['ls_group_by']=$group_by;
		//print $sql;
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Employee Travel";
		$this->_output['field'] = array("name"=>array("Name", 1),"traveltype"=>array("Travel Type",1),"travelmode"=>array("Travel Mode",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "name";
		if(isset($this->_input['qstart']) || isset($this->_input['search_status'])){
			$this->report_bl->page_listing($this,"report/travelSummeryListing");
		}else{
			$this->report_bl->page_listing($this,"report/searchTravel");
		}
	}
	
#########################################################################################
### Function Name : _travelDetail				      	              ###
### Description   : Function to show travel detail of an employee 		      ###
### Input         : Employee id						      	      ###
### Ouput	  : General travelDetail template            	                      ###
#########################################################################################
	function _travelDetail(){
		if(!$_SESSION['id_user']){
			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>");
		}

		$sql=get_search_sql("companytraveltype");
		$res=getindexrows($sql,"id_travel_type","travel_type");
		$this->_output['travel_type'] =$res;
		$sqltravelmode=get_search_sql("companytravelmode");
		$restravelmode=getindexrows($sql,"id_travel_mode","travel_mode");
		$this->_output['travel_mode'] =$restravelmode;
		$uri = 'index.php/page-report-choice-travelDetail';
		$uri.="-id-".$this->_input['id'];
		if($this->_input['group_by']==1){
			$cond='travel_type="'.$this->_input['traveltype'].'"';
			$uri.="-group_by-".$this->_input['group_by'];
			$uri.="-traveltype-".$this->_input['traveltype'];
		}else if($this->_input['group_by']==3){
			$cond='travel_mode="'.$this->_input['travelmode'].'"';
			$uri.="-group_by-".$this->_input['group_by'];
			$uri.="-travelmode-".$this->_input['travelmode'];
		}else{
			$cond='1';
		}

		$sql='SELECT * FROM (SELECT id_employee,travel_status,travel_type,travel_mode,notes, (SELECT concat(firstname," ",lastname) as name FROM '.TABLE_PREFIX.'employee WHERE id_employee=e.id_employee) as name,(SELECT travel_type from '.TABLE_PREFIX.'companytraveltype as travel_type WHERE id_travel_type=e.travel_type ) as traveltype,(SELECT travel_mode from '.TABLE_PREFIX.'companytravelmode as travelmode WHERE id_travel_mode=e.travel_mode ) as travelmode,from_date,to_date FROM '.TABLE_PREFIX.'employeetravelrequest e WHERE id_company='.$_SESSION['id_company'].' AND travel_status=2 AND '.$_SESSION['ls_cond'].' ) TEMP WHERE '.$cond.' AND id_employee='.$this->_input['id'];

		//print $sql;

		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Travel Details ";
		$this->_output['field'] = array("name"=>array("Name", 1),"travel_type"=>array("Travel Type",1),"travel_mode"=>array("Travel Mode",1),"notes"=>array("Notes",0),"from_date"=>array("From",1),"to_date"=>array("To",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "travel_type";
		$this->report_bl->page_listing($this,"report/travelDetail");
	}
    
/*********************** Expense Summary ********************************/
function _expenseSummary(){
		$sql=get_search_sql("companyExpenseMode");
		$res=getindexrows($sql,"id_expense_mode","expense_mode");
		$this->_output['expense_mode'] =$res;
		$uri = 'index.php/page-report-choice-expenseSummary';
		$cond=1;
		if($this->_input['expense_mode']){
			$cond.=" AND expense_mode ='".$this->_input['expense_mode']."'";
			$uri .= '-expense_mode-'.$this->_input['expense_mode'];
		}
		if($this->_input['id_employee']){
			$cond.=" AND e.id_employee ='".$this->_input['id_employee']."'";
			$uri .= '-id_employee-'.$this->_input['id_employee'];
		}
		$frmdate=$this->_input['frm_date'];
		$tmp_frmdate=str_replace("**","-",$frmdate);
		$todate=$this->_input['to_date'];
		$tmp_todate=str_replace("**","-",$todate);
		
		if($this->_input['group_by']=='2'){
			$group_by=' e.id_employee ';
			$uri .= '-group_by-'.$this->_input['group_by'];
		}else{
			$group_by=' CONCAT(e.expense_mode,e.id_employee) ';
			$uri .= '-group_by-1';
		}
		$con_frmdate=convertodate($tmp_frmdate,'dd-mm-yy','yyyy-mm-dd');
		$con_todate=convertodate($tmp_todate,'dd-mm-yy','yyyy-mm-dd');
		if($frmdate!='' && $todate!=''){
			$cond.=" AND ( ( '".$con_frmdate."' <= e.from_date AND '".$con_todate."' >= e.from_date ) ";
			$cond.=" OR ( '".$con_frmdate."' <= e.to_date AND '".$con_todate."' >= e.to_date )  ";
			$cond.=" OR ( '".$con_frmdate."' <= e.from_date AND '".$con_todate."' >= e.to_date )  ";
			$cond.=" OR ( '".$con_frmdate."' >= e.from_date AND '".$con_todate."' <= e.to_date ) ) ";
			$uri .= '-frm_date-'.str_replace("-","**",$frmdate);
			$uri .= '-to_date-'.str_replace("-","**",$todate);
		}else if($frmdate!=''){
			$cond.=" AND ( '".$con_frmdate."' <= e.from_date OR ( e.from_date <= '".$con_frmdate."' AND '".$con_frmdate."' <= e.to_date ) ) ";
			$uri .= '-frm_date-'.str_replace("-","**",$frmdate);
		}else if($todate){
			$cond.=" AND ( '".$con_todate."' >= e.to_date  OR ( e.from_date <= '".$con_todate."' AND '".$con_todate."' <= e.to_date ) )";
			$uri .= '-to_date-'.str_replace("-","**",$todate);
		}
		
		$sql='SELECT id_employee,expense_status,expense_mode, (SELECT CONCAT(firstname," ",lastname) as name FROM '.TABLE_PREFIX.'employee WHERE id_employee=e.id_employee) as name,sum(expense_amount) as total,(SELECT expense_mode from '.TABLE_PREFIX.'companyExpenseMode as expense_mode WHERE id_expense_mode = e.expense_mode ) as emode,from_date,to_date FROM '.TABLE_PREFIX.'employeeExpenseRequest e WHERE id_company='.$_SESSION['id_company'].' AND expense_status=2 AND '.$cond.' GROUP BY '.$group_by;
		$_SESSION['ls_cond']=$cond;
		$_SESSION['ls_group_by']=$group_by;
		//print $sql;
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Employee Expenses";
		$this->_output['field'] = array("name"=>array("Name", 1),"total"=>array("Total Expenses", 1), "emode"=>array("Expense Type",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "name";
		if(isset($this->_input['qstart']) || isset($this->_input['search_status'])){
			$this->report_bl->page_listing($this,"report/expenseSummeryListing"); 
		}else{
			$this->report_bl->page_listing($this,"report/searchExpense"); 
		}
	}
#########################################################################################
### Function Name : _leaveDetail				      	              ###
### Description   : Function to show leave detail of an employee 		      ###
### Input         : Employee id						      	      ###
### Ouput	  : General leaveDetail template            	                      ###
#########################################################################################
	function _expenseDetail(){
		if(!$_SESSION['id_user']){
			exit("<span class='fcolor'>".getmessage('COM_NO_SESSION')."</span>");
		}
		$sql=get_search_sql("companyExpenseMode");
		$res=getindexrows($sql,"id_expense_mode","expense_mode");
		$this->_output['expense_mode'] =$res;
		$uri = 'index.php/page-report-choice-expenseDetail';
		$uri.="-id-".$this->_input['id'];
		if($this->_input['group_by']==1){
			$cond='expense_mode="'.$this->_input['emode'].'"';
			$uri.="-group_by-".$this->_input['group_by'];
			$uri.="-emode-".$this->_input['emode'];
		}else{
			$cond='1';
		}
		
		$sql='SELECT * FROM (SELECT id_employee,expense_status,expense_mode,notes, (SELECT concat(firstname," ",lastname) as name FROM '.TABLE_PREFIX.'employee WHERE id_employee=e.id_employee) as name,expense_amount as total,(SELECT expense_mode from '.TABLE_PREFIX.'companyExpenseMode as expense_mode WHERE id_expense_mode = e.expense_mode ) as emode,from_date,to_date FROM '.TABLE_PREFIX.'employeeExpenseRequest e WHERE id_company='.$_SESSION['id_company'].' AND expense_status=2 AND '.$_SESSION['ls_cond'].' ) TEMP WHERE '.$cond.' AND id_employee='.$this->_input['id'];

		//print $sql;
		
		$this->_output['type']	= "box";  // no, extra, nextprev, advance, normal, box
		$this->_output['pg_header'] = "Expense Details ";
		$this->_output['field'] = array("name"=>array("Name", 1),"total"=>array("Working Days", 1), "expense_mode"=>array("Expense Type",1),"notes"=>array("Notes",0),"from_date"=>array("From",1),"to_date"=>array("To",1));
		$this->_output['limit'] = $GLOBALS['conf']['PAGINATE']['rec_per_page'];
		$this->_output['show'] = $GLOBALS['conf']['PAGINATE']['show_page'];
		$this->_output['sql'] = $sql;
		$this->_output['uri'] = $uri;
		$this->_output['ajax']= "ajax";
		$this->_output['sort_order']= "DESC";
		$this->_output['sort_by']= "expense_mode";
		$this->report_bl->page_listing($this,"report/expenseDetail"); 
	}    
}//end of class
