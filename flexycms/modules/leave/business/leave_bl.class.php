<?php
/**
 * Class   : adminstration_bl
 * Purpose : All data query(DQL) of administration manager done here. 
 */
class leave_bl extends business{
##########################################################
### Function Name : countLeave			       ###
### Description   : Function to count employees for a leave
### Input         : No input 			       ###
### Ouput 	  : sql query		      	       ###
##########################################################
	function countLeave(){
		$sql="SELECT COUNT(id_employee) AS cnt,leave_type FROM ".TABLE_PREFIX."employeeLeaveRequest GROUP BY leave_type";
		return $sql;
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
};
