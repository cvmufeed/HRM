<?php
/**
 * Class   : adminstration_bl
 * Purpose : All data query(DQL) of administration manager done here. 
 */
class adminstration_bl extends business{
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
};
