<?php
class employee_bl extends business{
#####################################################################################################
# Function Name : getEmployeeRecord                                                                 #
# Description   : Function to get employee detail and sets some of information in session           #
# Input         : id_employee			                                                    #
# Output	: Returns fetch result		  				                    #
#####################################################################################################
	function getEmployeeRecord($id=''){
		global $link;
		if($_SESSION['id_company']){ 
			$id_employee=$id;
			$cond=" AND id_company='".$_SESSION['id_company']."' ";
		}else{ 
			$id_employee=$_SESSION['id_employee'];
			$cond=" AND 1 ";
		}
		$cond=" id_employee='".$id_employee."' ".$cond." LIMIT 1";
		if($id=='for_leave' && $_SESSION['id_company']!=''){
			$cond=" id_company='".$_SESSION['id_company']."' ";
		}
		$sql="SELECT *,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name FROM ".TABLE_PREFIX."employee WHERE ".$cond;
		$res=getsingleindexrow($sql);
		if($res) {
			$sql_job="SELECT De.dept_name,Di.div_name FROM ".TABLE_PREFIX."companyDivision Di,".TABLE_PREFIX."companyDepartment De WHERE De.id_division=Di.id_division AND De.id_department=".$res['department']." LIMIT 1";

			$job_detail=getsingleindexrow($sql_job);

			if($res['job_title']){
				$sql_jobtitle="SELECT job_title_name FROM ".TABLE_PREFIX."companyJobTitle WHERE id_job_title=".$res['job_title']." LIMIT 1";
				$jobtitle=getsingleindexrow($sql_jobtitle);
			}
			if($res['team']){
				$sql_team="SELECT team_name FROM ".TABLE_PREFIX."companyTeam WHERE id_team=".$res['team']." LIMIT 1";
				$team=getsingleindexrow($sql_team);
			}

			$_SESSION['cur_emp_id']=$res['id_employee'];
			$_SESSION['avatar']=$res['avatar'];
			$_SESSION['gender']=$res['gender'];
			$_SESSION['emp_email']=$res['work_email'];
			$_SESSION['fullname']=$res['firstname']." ".$res['middlename']." ".$res['lastname'];
			$_SESSION['jobtitlename']=$jobtitle['job_title_name'];
			$_SESSION['teamname']=$team['team_name'];
			$_SESSION['departmentname']=$job_detail['dept_name'];
			$_SESSION['divname']=$job_detail['div_name'];
			$_SESSION['empstatus']=$res['emp_status'];
			$_SESSION['emp_company']=$res['id_company'];
		
			$res_terminate=getsingleindexrow('CALL get_search_sql("'.TABLE_PREFIX.'employeeTerminationContract","'."id_employee=".$res['id_employee']." AND terminate_date <= NOW() LIMIT 1".'")');
			if($res_terminate){
				$_SESSION['empstatus']=-1;
			}
		}
		return $res;		
	}
#####################################################################################################
# Function Name : getEmployeeListSql                                                                #
# Description   : Sql to fetch employee list						            #
#					                                                            #
# Input         : condition			                                                    #
# Output	: Returns sql			  				                    #
#####################################################################################################
	function getEmployeeListSql($cond="1"){
		$sql="SELECT id_employee,firstname,middlename,lastname,gender,job_title,emp_status,joined_date,work_email,work_phone,avatar,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,job_title_name,CJT.job_title_name FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE LEFT JOIN ".TABLE_PREFIX."companyJobTitle CJT ON TE.job_title=CJT.id_job_title WHERE ".$cond." AND id_company=".$_SESSION['id_company'];
		
		return $sql;
	}
#####################################################################################################
# Function Name : getLatestModifiedEmployees                                                        #
# Description   : Sql to fetch latest modified employee list				            #
#					                                                            #
# Input         : condition			                                                    #
# Output	: Returns sql			  				                    #
#####################################################################################################
	function getLatestModifiedEmployees(){
		$interval= $GLOBALS['conf']['LATEST_MODIFIED_EMPLOYEES']['BEFORE'];
		$limit= $GLOBALS['conf']['LATEST_MODIFIED_EMPLOYEES']['SHOWN_RECORDS'];
		
		$sql="SELECT E.id_employee,modify_date,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee WHERE modify_date  BETWEEN DATE_FORMAT(DATE_SUB(NOW(),INTERVAL ".$interval." DAY),'%Y-%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY),'%Y-%m-%d') AND IF(terminate_date!='',terminate_date > NOW(),1) "." AND E.id_company='".$_SESSION['id_company']."' "." ORDER BY modify_date DESC LIMIT ".$limit;
		
		return getindexrows($sql,'id_employee','name',$err);
	}
#####################################################################################################
# Function Name : getLatestViewedEmployees                                                          #
# Description   : Sql to fetch latest viewed employee list				            #
#					                                                            #
# Input         : condition			                                                    #
# Output	: Returns sql			  				                    #
#####################################################################################################
	function getLatestViewedEmployees(){
		$interval= $GLOBALS['conf']['LATEST_VIEWED_EMPLOYEES']['BEFORE'];
		$limit= $GLOBALS['conf']['LATEST_VIEWED_EMPLOYEES']['SHOWN_RECORDS'];
		
		$sql="SELECT E.id_employee,modify_date,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee WHERE view_date  BETWEEN DATE_FORMAT(DATE_SUB(NOW(),INTERVAL ".$interval." DAY),'%Y-%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY),'%Y-%m-%d') AND IF(terminate_date!='',terminate_date > NOW(),1) "." AND E.id_company='".$_SESSION['id_company']."' "." ORDER BY view_date DESC LIMIT ".$limit;
		
		return getindexrows($sql,'id_employee','name',$err);
	}
#####################################################################################################
# Function Name : getLatestAddedEmployees                                                           #
# Description   : Sql to fetch latest added employee list				            #
#					                                                            #
# Input         : condition			                                                    #
# Output	: Returns sql			  				                    #
#####################################################################################################
	function getLatestAddedEmployees(){
		$interval= $GLOBALS['conf']['LATEST_ADDED_EMPLOYEES']['BEFORE'];
		$limit= $GLOBALS['conf']['LATEST_ADDED_EMPLOYEES']['SHOWN_RECORDS'];
		
		$sql="SELECT E.id_employee,E.add_date,modify_date,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee WHERE E.add_date  BETWEEN DATE_FORMAT(DATE_SUB(NOW(),INTERVAL ".$interval." DAY),'%Y-%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY),'%Y-%m-%d') AND IF(terminate_date!='',terminate_date > NOW(),1) "." AND E.id_company='".$_SESSION['id_company']."' "." ORDER BY add_date DESC LIMIT ".$limit;
		return getindexrows($sql,'id_employee','name',$err);
	}
#####################################################################################################
# Function Name : autoEmpName                          			                            #
# Description   : Sql for autocomplete of employee name					            #
#					                                                            #
# Input         : condition			                                                    #
# Output	: Returns sql			  				                    #
#####################################################################################################
	function autoEmpName($cond="",$q){
		$sql="SELECT id_employee,name,avatar,gender FROM ( SELECT E.*,terminate_date , CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee WHERE E.id_company=".$_SESSION['id_company']." ".$cond.") AS temp_emp WHERE name LIKE '%".$q."%' ORDER BY temp_emp.name ";
		
		return $sql;
	}
#####################################################################################################
# Function Name : getAvatarData                       			                            #
# Description   : Sql to get avatar information						            #
#					                                                            #
# Input         : No Input			                                                    #
# Output	: Returns result set		  				                    #
#####################################################################################################
	function getAvatarData(){
		global $link;
		$sql_avatar="SELECT id_employee,avatar,gender FROM ".TABLE_PREFIX."employee WHERE id_employee='".$_SESSION['cur_emp_id']."' LIMIT 1";
		return getsingleindexrow($sql_avatar);
	}
#####################################################################################################
# Function Name : checkPropertyExistance               			                            #
# Description   : It returns no. of property type named as same				            #
#					                                                            #
# Input         : id_property_type,property name,serial no                                          #
# Output	: Returns no. of same property type  				                    #
#####################################################################################################
	function checkPropertyExistance($id_property_type,$property_name,$serial_no){
		global $link;
		$sql_exist="SELECT * FROM ".TABLE_PREFIX."employeeProperties Ep,".TABLE_PREFIX."propertyType Pt WHERE Ep.id_property_type=Pt.id_property_type AND Pt.id_company=".$_SESSION['id_company']." AND Ep.id_property_type=".$id_property_type." AND Ep.property_name='".trim($property_name)."' AND Ep.serial_no='".trim($serial_no)."'";
		return mysql_num_rows($link->query($sql_exist));	
	}
#####################################################################################################
# Function Name : getEmployees		               			                            #
# Description   : It gives employee list						            #
#					                                                            #
# Input         : condition				                                            #
# Output	: Returns result set		  				                    #
#####################################################################################################
	function getEmployees($cond){
		$employee_sql="SELECT id_employee,gender,avatar,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name FROM ".TABLE_PREFIX."employee WHERE ".$cond;
		return getindexrows($employee_sql,"id_employee");
	}
}
