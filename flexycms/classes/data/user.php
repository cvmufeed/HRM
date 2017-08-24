<?php
/*
 * Class   : user 
 * Purpose : All business logic(Data Manipulation) related to user_manager done here
 */
class user{
##################################################
### Function Name : changePwd				   ###
### Description   : Function to reset password ###
### Input         : Form input with array type ###
### Output		  : Updated result set   	   ###
##################################################
	function changePwd($pwdArray){
		$table     = $pwdArray['utype'] == 'c' ? "company" : "employee";
		$cond_name = $pwdArray['utype'] == 'c' ? "id_company" : "id_employee";
		$sql   = "UPDATE ".TABLE_PREFIX.$table." SET password = '".MD5($pwdArray['npass'])."' WHERE md5(".$cond_name.") = '".$pwdArray['uid']."'";
		execute($sql);
		return mysqli_affected_rows();
	}
	
	function lastLogin($table,$cond){
		$sql = "UPDATE ".TABLE_PREFIX.$table." SET last_login = NOW(),ip = '".$_SERVER['REMOTE_ADDR']."' WHERE ".$cond." LIMIT 1";
		execute($sql,$err);
	}
}
