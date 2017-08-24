<?php
class report_bl extends business{
###################################################
########## GET EMPLOYEE SALARY LIST SQL ###########
###################################################
	function getEmployeeSalListSql($cond="1"){
		$sql="SELECT id_employee,firstname,middlename,lastname,gender,job_title,team,emp_status,avatar,division,department,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,job_title_name,CJT.job_title_name,if(pay_frequency=1,salary*12,(if(pay_frequency=2,salary*52,salary*365))) AS annual_sal FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE LEFT JOIN ".TABLE_PREFIX."companyJobTitle CJT ON  TE.job_title=CJT.id_job_title WHERE ".$cond." AND id_company=".$_SESSION['id_company'];
		
		return $sql;
	}
###################################################
############# GET EMPLOYEE JOININGS ###############
###################################################
	function getEmployeeJoiningsListSql($cond="1"){
		$sql="SELECT id_employee,firstname,middlename,lastname,gender,job_title,team,emp_status,joined_date,avatar,division,department,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name,job_title_name,CJT.job_title_name,if(pay_frequency=1,salary*12,(if(pay_frequency=2,salary*52,salary*365))) AS annual_sal FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE LEFT JOIN ".TABLE_PREFIX."companyJobTitle CJT ON  TE.job_title=CJT.id_job_title WHERE ".$cond." AND id_company=".$_SESSION['id_company'];
		
		return $sql;
	}
###################################################
######### GET EMPLOYEE UPCOMING BIRTHDAYS #########
###################################################
	function getEmployeeUpcomingBirthdayListSql($cond="1"){
		$sql="SELECT id_employee,firstname,middlename,lastname,dob,CONCAT(firstname,' ',if(middlename!='NULL',CONCAT(middlename,' '),''),if(lastname!='NULL',lastname,'')) AS name FROM (SELECT E.*,ETC.terminate_date FROM ".TABLE_PREFIX."employee E LEFT JOIN ".TABLE_PREFIX."employeeTerminationContract ETC ON E.id_employee=ETC.id_employee) AS TE WHERE ".$cond." AND id_company=".$_SESSION['id_company'];
		
		return $sql;
	}
}
?>
